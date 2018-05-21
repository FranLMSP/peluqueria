<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Occupation;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'employees' => Employee::with('occupation')->get()
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
            'occupations' => Occupation::get()
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
            'names' => 'required|max:255',
            'surnames' => 'nullable|max:255',
            'identity_number' => 'required|integer|unique:employees,identity_number',
            'profile_pic' => 'nullable|image',
            'email' => 'nullable|email',
            'phone' => '',
            'birthdate' => 'required|date',
            'occupation' => 'required|integer|exists:occupations,id'
        ], [
            'names.required' => 'El campo nombre es obligatorio',
            'names.max' => 'El nombre no debe pasar de los 255 caracteres',
            'surnames.required' => 'El campo apellido es obligatorio',
            'surnames.max' => 'El apellido no debe pasar de los 255 caracteres',
            'identity_number.required' => 'En número de identidad es obligatorio',
            'identity_number.integer' => 'En número de identidad no es válido',
            'identity_number.unique' => 'En número de identidad ya está en uso',
            'profile_pic.image' => 'El formato de la imagen no es válido',
            'email.email' => 'El email no es válido',
            'birthdate.required' => 'Debe especificar la fecha de nacimiento',
            'birthdate.date' => 'La fecha de nacimiento no es válida',
            'occumation.required' => 'Debe especificar una ocupación',
            'occupation.integer' => 'La ocupación no es válida',
            'occupation.exists' => 'La ocupación no existe',
        ]);

        $request->merge(['occupation_id' => $request->occupation]);

        $employee = new Employee($request->all());

        if ($request->hasFile('profile_pic') && $request->file('profile_pic')->isValid()) {
            $filename = $this->getFileName($request->profile_pic);
            $request->profile_pic->move( base_path('public/storage/employees'), $filename );
            $employee->profile_pic = $filename;
        } else {
            $employee->profile_pic = NULL;
        }


        $employee->save();

        return response()->json([
            'employee' => $employee->load('occupation')   
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        return response()->json([
            'employee' => $employee->load('occupation')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        return response()->json([
            'employee' => $employee->load('occupation'),
            'occupations' => Occupation::get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        $validation = [];
        if(isset($request->profile_pic) && $request->profile_pic == $employee->profile_pic) {
            $validation = [
                'names' => 'required|max:255',
                'surnames' => 'nullable|max:255',
                'identity_number' => 'required|integer|unique:employees,identity_number,'.$employee->id,
                'profile_pic' => '',
                'email' => 'nullable|email',
                'phone' => '',
                'birthdate' => 'required|date',
                'occupation' => 'required|integer|exists:occupations,id'
            ];
            $imageChange = false;
        } else {
            $validation = [
                'names' => 'required|max:255',
                'surnames' => 'nullable|max:255',
                'identity_number' => 'required|integer|unique:employees,identity_number,'.$employee->id,
                'profile_pic' => 'nullable|image',
                'email' => 'nullable|email',
                'phone' => '',
                'birthdate' => 'required|date',
                'occupation' => 'required|integer|exists:occupations,id'
            ];
            $imageChange = true;
        }
        $request->validate($validation, [
            'names.required' => 'El campo nombre es obligatorio',
            'names.max' => 'El nombre no debe pasar de los 255 caracteres',
            'surnames.required' => 'El campo apellido es obligatorio',
            'surnames.max' => 'El apellido no debe pasar de los 255 caracteres',
            'identity_number.required' => 'En número de identidad es obligatorio',
            'identity_number.integer' => 'En número de identidad no es válido',
            'identity_number.unique' => 'En número de identidad ya está en uso',
            'profile_pic.image' => 'El formato de la imagen no es válido',
            'email.email' => 'El email no es válido',
            'birthdate.required' => 'Debe especificar la fecha de nacimiento',
            'birthdate.date' => 'La fecha de nacimiento no es válida',
            'occumation.required' => 'Debe especificar una ocupación',
            'occupation.integer' => 'La ocupación no es válida',
            'occupation.exists' => 'La ocupación no existe',
        ]);

        $data = $request->all();

        $data['occupation_id'] = $request->occupation;

        if ($request->hasFile('profile_pic') && $request->file('profile_pic')->isValid()) {

            if (file_exists('public/storage/employees/'.$employee->profile_pic))
                unlink('public/storage/employees/'.$employee->definition->profile_pic);

            $filename = $this->getFileName($request->profile_pic);
            $request->profile_pic->move( base_path('public/storage/employees'), $filename );
            $employeeImage = $filename;
        } else if($imageChange) {
            $employeeImage = NULL;
        } else {
            $employeeImage = $employee->profile_pic;
        }

        $data['profile_pic'] = $employeeImage;

        $employee->update($data);

        return response()->json([
            'employee' => $employee
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        //
    }

public function birthdays(Request $request)
    {
        $result = Employee::select([
            'id',
            'identity_number',
            'names',
            'surnames',
            'birthdate'
        ])->get();

        $employees = [];

        foreach($result as $row) {
            $birthdate = '2000-'.date('m-d', strtotime($row->birthdate));

            $now = '2000-'.date('m-d');
            $finish = '2000-'.date('m-d', strtotime('+7 days'));

            if(strtotime($birthdate) >= strtotime($now) && strtotime($birthdate) <= strtotime($finish)) {
                $employees[] = $row;
            }

        }

        usort($employees, function ($item1, $item2) {
            $date1 = date('m-d', strtotime($item1['birthdate']));
            $date2 = date('m-d', strtotime($item2['birthdate']));

            return strtotime('2000-'.$date1) <=> strtotime('2000-'.$date2);
        });

        return response()->json([
            'employees' => $employees
        ]);
    }

    protected function getFileName($file)
    {
        return uniqid('employee_').'.'.$file->extension();
    }
}
