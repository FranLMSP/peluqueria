<?php

namespace App\Http\Controllers;

use App\Company;
use App\Region;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::with([
            'commune',
            'commune.region'
        ])->get();

        return response()->json([
            'companies' => $companies
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
            'regions' => Region::with(['communes'])->get()
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
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'secondary_phone' => '',
            'email' => 'required',
            'website' => '',
            'shortname' => '',
            'color' => '',
            'boxes' => 'required|integer',
            'commune_id' => 'required|exists:communes,id',
            'image' => 'nullable|image'
        ], [
            'name.required' => 'El campo nombre es requerido',
            'address.required' => 'La dirección es requerida',
            'phone.required' => 'Debe especificar el número de teléfono principal',
            'email.required' => 'Debe especificar el email',
            'boxes.required' => 'Debe especificar número de sillones',
            'boxes.integer' => 'El número de sillones no es válido',
            'commune_id.required' => 'Debe especificar la comuna',
            'commune_id.integer' => 'La comuna no es válida',
            'commune_id.exists' => 'La comuna no existe',
            'image.image' => 'El formato de la imagen no es válido',
        ]);

        $req = $request->all();
        $req['image'] = NULL;
        $company = new Company($req);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $filename = $this->getFileName($request->image);
            $request->image->move( base_path('public/storage/companies'), $filename );
            $company->image = $filename;
        } else {
            $company->image = NULL;
        }

        $company->save();

        return response()->json([
            'company' => $company
        ], 201);
    }

    protected function getFileName($file)
    {
        return uniqid('company_').'.'.$file->extension();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        return response()->json([
            'company' => $company->load(['commune', 'commune.region'])
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        //
    }
}
