<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'customers' => Customer::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'names' => 'required',
            'identity_number' => 'integer|required|unique:customers,identity_number'
        ], [
            'names' => 'Debe especificar el nombre del cliente',
            'identity_number.integer' => 'El número de identidad debe ser numérico',
            'identity_number.required' => 'El número de identidad es obligatorio',
            'identity_number.unique' => 'Ya existe un cliente con ese número de identidad'
        ]);

        Customer::create($request->all());

        return response()->json([
            'message' => 'Creado correctamente'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json([
            'customer' => Customer::findOrFail($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return response()->json([
            'customer' => Customer::findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'names' => 'required',
            'identity_number' => 'integer|required|unique:customers,identity_number,'.$id
        ], [
            'names' => 'Debe especificar el nombre del cliente',
            'identity_number.integer' => 'El número de identidad debe ser numérico',
            'identity_number.required' => 'El número de identidad es obligatorio',
            'identity_number.unique' => 'Ya existe un cliente con ese número de identidad'
        ]);

        Customer::where('id', $id)->update($request->all());

        return response()->json([
            'message' => 'Actualizado correctamente'
        ]);
    }

    public function birthdays(Request $request)
    {
        $result = Customer::select([
            'id',
            'identity_number',
            'names',
            'surnames',
            'birthdate'
        ])->get();

        $customers = [];

        foreach($result as $row) {
            $birthdate = '2000-'.date('m-d', strtotime($row->birthdate));

            $now = '2000-'.date('m-d');
            $finish = '2000-'.date('m-d', strtotime('+7 days'));

            if(strtotime($birthdate) >= strtotime($now) && strtotime($birthdate) <= strtotime($finish)) {
                $customers[] = $row;
            }

        }

        usort($customers, function ($item1, $item2) {
            $date1 = date('m-d', strtotime($item1['birthdate']));
            $date2 = date('m-d', strtotime($item2['birthdate']));

            return strtotime('2000-'.$date1) <=> strtotime('2000-'.$date2);
        });

        return response()->json([
            'customers' => $customers
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
