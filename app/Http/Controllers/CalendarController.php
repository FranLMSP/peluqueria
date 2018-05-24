<?php

namespace App\Http\Controllers;

use App\Calendar;
use App\CalendarStatus;
use App\Customer;
use App\Product;
use App\Employee;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statuses = CalendarStatus::select(
            'id',
            'name',
            'description',
            'active'
        )->get();


        $customers = Customer::select(
            'id',
            'names',
            'surnames',
            'identity_number',
            'email',
            'phone'
        )->get();

        $services = Product::select(
            'id',
            'product_header_id'
        )->where('active', true)
        ->whereHas('definition', function($query){
            $query->whereType('S');
        })->with([
            'definition' => function($query) {
                $query->select(
                    'id',
                    'name',
                    'description'
                );
            }
        ])->get();

        $employees = Employee::select(
            'id',
            'names',
            'surnames',
            'identity_number',
            'occupation_id'
        )->with([
            'occupation' => function($query) {
                $query->select(
                    'id',
                    'name',
                    'description'
                );
            }
        ])->get();

        return response()->json([
            'services' => $services,
            'employees' => $employees,
            'statuses' => $statuses,
            'customers' => $customers,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'employee_id' => 'required|exists:employees,id',
            'service_id' => 'required|exists:products,id',
            'notes' => '',
            'status_id' => 'required|exists:calendar_statuses,id',
            'date' => 'date',
            'customer' => 'nullable|array',
            'customer.names' => 'required',
            'customer.surnames' => '',
            'customer.identity_number' => 'required|unique:customers,identity_number',
            'customer.email' => 'nullable|email',
            'customer.phone' => ''
        ], [
            'customer_id.exists' => 'El cliente especificado no existe',
            'employee_id.exists' => 'El empleado no existe',
            'employee_id.required' => 'Debe especificar el empleado',
            'service_id.exists' => 'El servicio especificado no existe',
            'service_id.exists' => 'Debe especificar el servicio',
            'status_id.required' => 'Debe especificar un status',
            'date.date' => 'El formato de la fecha no es válido',
            'customer.array' => 'El formato del cliente nuevo no es válido',
            'customer.names.required' => 'Debe especificar el nombre del cliente',
            'customer.identity_number.required' => 'Debe especificar el número de identidad',
            'customer.identity_number.unique' => 'Ya existe un cliente con ese número de identidad',
            'customer.email.email' => 'El email no es válido',
        ]);

        if($request->customer_id) {
            $calendar = new Calendar([
                'customer_id' => $request->customer_id,
                'service_id' => $request->service_id,
                'employee_id' => $request->employee_id,
                'status_id' => $request->status_id,
                'notes' => $request->notes,
                'date' => $request->date,
            ]);
        } else {
            $customer = new Customer([
                'names' => $request->customer['names'],
                'surnames' => $request->customer['surnames'],
                'identity_number' => $request->customer['identity_number'],
                'email' => $request->customer['email'],
                'phone' => $request->customer['phone']
            ]);

            $customer->save();

            $calendar = new Calendar([
                'customer_id' => $customer->id,
                'service_id' => $request->service_id,
                'employee_id' => $request->employee_id,
                'status_id' => $request->status_id,
                'notes' => $request->notes,
                'date' => $request->date,
                'email' => $request->email,
            ]);
        }

        $calendar->save();

        return response()->json([
            'calendar' => $calendar
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function show(Calendar $calendar)
    {
        //
    }

    public function month($month) 
    {

        $date = explode('-', $month);

        if(!isset($date[0]) || !$date[0] || !isset($date[1]) || !$date[1]) {
            return response()->json([
                'error' => 'El formato de la fecha no es válido'
            ]);
        }

        $pastMonth = date('Y-m-d', strtotime('-7 days', strtotime($date[0].'-'.$date[1].'-1') ));
        $nextMonth = date('Y-m-d', strtotime('+1 months', strtotime($date[0].'-'.$date[1].'-7') ));

        $calendar = Calendar::with([
            'status',
            'customer',
            'service',
            'service.definition',
            'employee',
            'employee.occupation',
        ])->whereBetween('date', [
            $pastMonth,
            $nextMonth
        ])->get();

        return response()->json([
            'calendar' => $calendar
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function edit(Calendar $calendar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Calendar $calendar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Calendar  $calendar
     * @return \Illuminate\Http\Response
     */
    public function destroy(Calendar $calendar)
    {
        //
    }
}
