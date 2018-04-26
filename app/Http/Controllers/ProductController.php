<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductHeader;
use Illuminate\Http\Request;

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
            'products' => Product::all()->where('active', true)->with('definition')
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
            'description' => ''
        ]);

        $productHeader = new ProductHeader([
            'name' => $request->name,
            'description' => $request->description
        ]);

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
