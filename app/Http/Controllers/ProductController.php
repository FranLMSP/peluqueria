<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductHeader;
use Illuminate\Http\Request;
use File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'products' => Product::where('active', true)->with('definition')->get()
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
            'name' => 'required|max:200',
            'price' => 'required',
            'image' => 'nullable|image',
            'description' => ''
        ],[
            'name.required' => 'El campo nombre es requerido',
            'name.max' => 'El campo nombre tiene máximo 200 caracteres',
            'price' => 'El precio es requerido',
            'image' => 'El formato de la imagen no es válido'
        ]);

        $productHeader = new ProductHeader([
            'name' => $request->name,
            'description' => $request->description
        ]);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $filename = $this->getFileName($request->image);
            $request->image->move( base_path('public/storage/products'), $filename );
            $productHeader->image = $filename;
        } else {
            $productHeader->image = NULL;
        }


        $productHeader->save();

        $product = new Product([
            'price' => $request->price,
            'product_header_id' => $productHeader->id
        ]);

        $product->save();
        $product->definition = $productHeader;

        return response()->json([
            'product' => $product
        ], 201);
    }

    protected function getFileName($file)
    {
        return uniqid('product_').'.'.$file->extension();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return response()->json([
            'product' => $product->load('definition')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|max:200',
            'price' => 'required',
            'description' => ''
        ]);

        ProductHeader::where('id', $product->definition->id)
            ->update([
                'name' => $request->name,
                'description' => $request->description
            ]);

        if ($product->price != $request->price) {
            $product->active = false;
            $product->save();

            $newProduct = Product::create([
                'price' => $request->price,
                'product_header_id' => $product->definition->id
            ]);

            return response()->json([
                'product' => $newProduct
            ]);

        }

        return response()->json([
            'product' => $newProduct
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
