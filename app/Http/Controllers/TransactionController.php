<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\TransactionType;
use App\Provider;
use App\Product;
use App\Inventory;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //EXAMPLE!
        $transactions = Transaction::with([
            'customer',
            'provider',
            'type',
            'products',
            'products.product',
            'products.product.definition'
        ])->get();

        return response()->json([
            'transactions' => $transactions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::where('active', true)
            ->whereHas('definition', function($query){
                $query->whereType('P');
            })
            ->orderBy('created_at', 'DESC')->with('definition')->get();

        $types = TransactionType::get();

        $providers = Provider::get();

        return response()->json([
            'types' => $types,
            'providers' => $providers,
            'products' => $products
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
            'customer' => 'nullable|exists:customers,id',
            'provider' => 'nullable|exists:providers,id',
            'type' => 'required|exists:transaction_types,id',
            'description' => '',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.qty' => 'required|integer'
        ], [
            'customer.exists' => 'El cliente no existe',
            'provider.exists' => 'El proveedor no existe',
            'type.required' => 'Debe especificar el tipo de transaccion',
            'type.exists' => 'El tipo de transacción no existe',
            'products.required' => 'Debe especificar al menos un producto',
            'products.min' => 'Debe especificar al menos un producto',
            'products.array' => 'El formato de los productos no es válido',
            'products.*.required' => 'Debe especificar un producto',
            'products.*.id.exists' => 'El producto no existe',
            'products.*.qty.required' => 'Debe especificar la cantidad',
            'products.*.qty.integer' => 'El formato de la cantidad no es válido',
        ]);

        $transaction = new Transaction([
            'description' => $request->description,
            'customer_id' => $request->customer,
            'provider_id' => $request->provider,
            'transaction_type_id' => $request->type,
        ]);

        $transaction->save();

        $products = [];
        foreach($request->products as $product) {
            $products[] = new Inventory([
                'product_id' => $product['id'],
                'transaction_id' => $transaction->id,
                'qty' => $product['qty']
            ]);
        }

        $transaction->products()->saveMany($products);

        return response()->json([
            'transaction' => $transaction
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }



    public function inventory(Request $request)
    {
        $transactions = Transaction::with([
            'type',
            'products',
            'products.product',
            'products.product.definition'
        ])->get();

        $inventory = [];
        foreach($transactions as $keyTransaction => $transaction) {
            foreach($transaction->products as $keyProduct => $product) {
                $inventory[$product->product->definition->id]['product']['id'] = $product->product->definition->id;
                $inventory[$product->product->definition->id]['product']['name'] = $product->product->definition->name;
                $inventory[$product->product->definition->id]['product']['description'] = $product->product->definition->description;

                if(!isset($inventory[$product->product->definition->id]['existence'])) {
                    if($transaction->type->io == 'I') {
                        $inventory[$product->product->definition->id]['existence'] = $product->qty;
                    } else if( $transaction->type->io == 'O') {
                        $inventory[$product->product->definition->id]['existence'] = -$product->qty;
                    }
                } else {
                    if($transaction->type->io == 'I') {
                        $inventory[$product->product->definition->id]['existence']+= $product->qty;
                    } else if( $transaction->type->io == 'O') {
                        $inventory[$product->product->definition->id]['existence']-= $product->qty;
                    }
                }

            }
        }

        $inventory = array_values($inventory);

        return response()->json([
            'inventory' => $inventory
        ]);
    }

    public function sell(Request $request)
    {
        $request->validate([
            'customer' => 'nullable|exists:customers,id',
            'description' => '',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.qty' => 'required|integer'
        ], [
            'customer.exists' => 'El cliente no existe',
            'type.exists' => 'El tipo de transacción no existe',
            'products.required' => 'Debe especificar al menos un producto',
            'products.min' => 'Debe especificar al menos un producto',
            'products.array' => 'El formato de los productos no es válido',
            'products.*.required' => 'Debe especificar un producto',
            'products.*.id.exists' => 'El producto no existe',
            'products.*.qty.required' => 'Debe especificar la cantidad',
            'products.*.qty.integer' => 'El formato de la cantidad no es válido',
        ]);

        $type = TransactionType::where('sell', true)->first();

        $transaction = new Transaction([
            'description' => $request->description,
            'customer_id' => $request->customer,
            'provider_id' => NULL,
            'transaction_type_id' => $type->id,
        ]);

        $transaction->save();

        $products = [];
        foreach($request->products as $product) {
            $products[] = new Inventory([
                'product_id' => $product['id'],
                'transaction_id' => $transaction->id,
                'qty' => $product['qty']
            ]);
        }

        $transaction->products()->saveMany($products);

        return response()->json([
            'transaction' => $transaction
        ], 201);
    }
}
