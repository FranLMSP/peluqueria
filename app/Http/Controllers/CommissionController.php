<?php

namespace App\Http\Controllers;

use App\Commission;
use App\Product;
use App\Employee;
use Illuminate\Http\Request;

class CommissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $commissions = Commission::with([
            'service',
            'service.definition',
            'employee',
            'employee.occupation'
        ])->get();

        return response()->json([
            'commissions' => $commissions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->json([
            'services' => Product::where('active', true)
                ->whereHas('definition', function($query){
                    $query->whereType('S');
                })->with('definition')->get(),
            'employees' => Employee::with('occupation')->get()
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
            'commissions' => 'required|array|min:1',
            'commissions.*.employee' => 'required|exists:employees,id',
            'commissions.*.service' => 'required|exists:products,id',
            'commissions.*.percentage' => 'required|integer|min:0|max:100'
        ], [
            'commissions.required' => 'Debe especificar al menos una comisión',
            'commissions.min' => 'Debe especificar al menos una comisión',
            'commissions.*.employee.required' => 'Debe especificar el empleado',
            'commissions.*.employee.exists' => 'El empleado no existe',
            'commissions.*.service.required' => 'Debe especificar el servicio',
            'commissions.*.service.exists' => 'El servicio no existe',
            'commissions.*.percentage.required' => 'debe especificar el porcentaje',
            'commissions.*.percentage.min' => 'Debe ser mínimo 0%',
            'commissions.*.percentage.max' => 'Debe ser máximo 100%'
        ]);

        $commissions = [];
        foreach($request->commissions as $commission) {
            if(!$this->findEmployeeService($commission['employee'], $commission['service'], $commissions)) {
                $commissions[] = [
                    'employee_id' => $commission['employee'],
                    'service_id' => $commission['service'],
                    'percentage' => $commission['percentage']
                ];
            }
        }

        $result = Commission::insert($commissions);

        if($result) {
            return response()->json([
                'commissions' => $result
            ], 201);
        }

        return response()->json([
            'message' => 'Error al insertar las comisiones'
        ], 400);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Commission  $commission
     * @return \Illuminate\Http\Response
     */
    public function show(Commission $commission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Commission  $commission
     * @return \Illuminate\Http\Response
     */
    public function edit(Commission $commission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Commission  $commission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Commission $commission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Commission  $commission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Commission $commission)
    {
        //
    }





    private function findEmployeeService($employee, $service, $array = [])
    {
        foreach($array as $key => $commission) {
            if ($commission['employee_id'] == $employee && $commission['service_id'] == $service)
                return true;
        }
        return false;
    }
}
