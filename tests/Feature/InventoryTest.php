<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\TransactionType;
use App\Transaction;
use App\Inventory;
use App\Product;
use App\ProductHeader;
use App\Provider;
use App\Customer;

use App\User;

class InventoryTest extends TestCase
{
	use RefreshDatabase;

    /** @test */
    public function transactions_can_be_registered()
    {

        $this->withoutExceptionHandling();

    	$type = factory(TransactionType::class)->create([
    		'name' => 'Recepción',
    		'description' => 'Entrada de productos',
    		'io' => 'I'
    	]);


        $product = factory(Product::class)->create();

    	$otherProduct = factory(Product::class)->create();

        $provider = factory(Provider::class)->create();

		$user = factory(User::class)->create([
            'email' => 'admin@root.com',
            'password' => bcrypt('123456')
        ]);

        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

		$this->withHeaders(["Authorization" => 'Bearer '.$token])
			->json('POST', '/api/transactions', [
				'customer' => NULL,
				'provider' => $provider->id,
				'type' => $type->id,
				'products' => [
					[
						'id' => $product->id,
						'qty' => 5
					],
                    [
                        'id' => $otherProduct->id,
                        'qty' => 2
                    ]
				],
				'description' => 'Test transaction',
			])->assertStatus(201);

        $this->assertDatabaseHas('transactions',[
            'description' => 'Test transaction',
            'customer_id' => NULL,
            'provider_id' => $provider->id,
            'transaction_type_id' => $type->id,
        ]);

        $this->assertDatabaseHas('inventories', [
            'transaction_id' => 1,
            'product_id' => $product->id,
            'qty' => 5
        ]);

        $this->assertDatabaseHas('inventories', [
            'transaction_id' => 1,
            'product_id' => $otherProduct->id,
            'qty' => 2
        ]);
    }

    /** @test */
    public function transactions_can_be_listed()
    {
        //$this->withoutExceptionHandling();

        $type = factory(TransactionType::class)->create([
            'name' => 'Recepción',
            'description' => 'Entrada de productos',
            'io' => 'I'
        ]);

        $product = factory(Product::class)->create();

        $otherProduct = factory(Product::class)->create();

        $provider = factory(Provider::class)->create();

        $user = factory(User::class)->create([
            'email' => 'admin@root.com',
            'password' => bcrypt('123456')
        ]);

        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

        $transaction = new Transaction([
            'description' => 'Description',
            'customer_id' => NULL,
            'provider_id' => $provider->id,
            'transaction_type_id' => $type->id,
        ]);

        $transaction->save();

        $transaction->products()->saveMany([
            new Inventory([
                'product_id' => $product->id,
                'transaction_id' => $transaction->id,
                'qty' => 5
            ]),
            new Inventory([
                'product_id' => $otherProduct->id,
                'transaction_id' => $transaction->id,
                'qty' => 2
            ]),
        ]);

        $this->withHeaders(["Authorization" => 'Bearer '.$token])
            ->json('GET', '/api/transactions')
            ->assertStatus(200)
            ->assertExactJson([
                'transactions' => [
                    [
                        'id' => 1,
                        'customer_id' => NULL,
                        'provider_id' => $provider->id,
                        'transaction_type_id' => $type->id,
                        'description' => $transaction->description,
                        'created_at' => (string)$transaction->created_at,
                        'updated_at' => (string)$transaction->updated_at,
                        'deleted_at' => NULL,
                        'customer' => NULL,
                        'provider' => [
                            'id' => $provider->id,
                            'name' => $provider->name,
                            'description' => $provider->description,
                            'created_at' => (string)$transaction->created_at,
                            'updated_at' => (string)$transaction->updated_at,
                            'deleted_at' => NULL,
                        ],
                        'type' => [
                            'id' => $type->id,
                            'io' => $type->io,
                            'name' => $type->name,
                            'description' => $type->description
                        ],
                        'products' => [
                            [
                                'id' => 1,
                                'transaction_id' => $transaction->id,
                                'product_id' => $product->id,
                                'qty' => 5,
                                'created_at' => (string)$transaction->products[0]->created_at,
                                'updated_at' => (string)$transaction->products[0]->updated_at,
                                'deleted_at' => NULL,
                                'product' => [
                                    'id' => $product->id,
                                    'price' => $product->price,
                                    'product_header_id' => $product->product_header_id,
                                    'created_at' => (string)$product->created_at,
                                    'updated_at' => (string)$product->updated_at,
                                    'deleted_at' => NULL,
                                    'definition' => [
                                        'id' => $product->definition->id,
                                        'name' => $product->definition->name,
                                        'description' => $product->definition->description,
                                        'type' => $product->definition->type,
                                        'image' => NULL,
                                        'created_at' => (string)$product->definition->created_at,
                                        'updated_at' => (string)$product->definition->updated_at,
                                        'deleted_at' => NULL
                                    ]
                                ]
                            ],
                            [
                                'id' => 2,
                                'transaction_id' => $transaction->id,
                                'product_id' => $otherProduct->id,
                                'qty' => 2,
                                'created_at' => (string)$transaction->products[1]->created_at,
                                'updated_at' => (string)$transaction->products[1]->created_at, 
                                'deleted_at' => NULL,
                                'product' => [
                                    'id' => $otherProduct->id,
                                    'price' => $otherProduct->price,
                                    'product_header_id' => $otherProduct->product_header_id,
                                    'created_at' => (string)$otherProduct->created_at,
                                    'updated_at' => (string)$otherProduct->updated_at,
                                    'deleted_at' => NULL,
                                    'definition' => [
                                        'id' => $otherProduct->definition->id,
                                        'name' => $otherProduct->definition->name,
                                        'description' => $otherProduct->definition->description,
                                        'type' => $otherProduct->definition->type,
                                        'image' => NULL,
                                        'created_at' => (string)$otherProduct->definition->created_at,
                                        'updated_at' => (string)$otherProduct->definition->updated_at,
                                        'deleted_at' => NULL
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]);
    }

    /** @test */
    public function inventory_can_be_listed()
    {
        //$this->withoutExceptionHandling();

        $type = factory(TransactionType::class)->create([
            'name' => 'Recepción',
            'description' => 'Entrada de productos',
            'io' => 'I'
        ]);

        $product = factory(Product::class)->create();

        $otherProduct = factory(Product::class)->create();

        $provider = factory(Provider::class)->create();

        $user = factory(User::class)->create([
            'email' => 'admin@root.com',
            'password' => bcrypt('123456')
        ]);

        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

        $transaction = new Transaction([
            'description' => 'Description',
            'customer_id' => NULL,
            'provider_id' => $provider->id,
            'transaction_type_id' => $type->id,
        ]);

        $transaction->save();

        $transaction->products()->saveMany([
            new Inventory([
                'product_id' => $product->id,
                'transaction_id' => $transaction->id,
                'qty' => 5
            ]),
            new Inventory([
                'product_id' => $otherProduct->id,
                'transaction_id' => $transaction->id,
                'qty' => 2
            ]),
        ]);

        $secondType = factory(TransactionType::class)->create([
            'name' => 'Descpacho',
            'description' => 'Salida de productos',
            'io' => 'O'
        ]);

        $secondTransaction = new Transaction([
            'description' => 'Description',
            'customer_id' => NULL,
            'provider_id' => $provider->id,
            'transaction_type_id' => $secondType->id,
        ]);

        $secondTransaction->save();

        $secondTransaction->products()->saveMany([
            new Inventory([
                'product_id' => $product->id,
                'transaction_id' => $transaction->id,
                'qty' => 2
            ])
        ]);

        $this->withHeaders(["Authorization" => 'Bearer '.$token])
            ->json('GET', '/api/inventory')
            ->assertStatus(200)
            ->assertExactJson([
                'inventory' => [
                    [
                        'product' => [
                            'id' => $product->definition->id,
                            'name' => $product->definition->name,
                            'description' => $product->definition->description
                        ],
                        'existence' => 3
                    ],
                    [
                        'product' => [
                            'id' => $otherProduct->definition->id,
                            'name' => $otherProduct->definition->name,
                            'description' => $otherProduct->definition->description 
                        ],
                        'existence' => 2
                    ]
                ]
            ]);

    }


    /** @test */
    public function ingress_stock_create_data_can_be_listed()
    {
        //$this->withoutExceptionHandling();

        $type = factory(TransactionType::class)->create([
            'name' => 'Recepción',
            'description' => 'Entrada de productos',
            'io' => 'I'
        ]);

        $otherType = factory(TransactionType::class)->create([
            'name' => 'Despacho',
            'description' => 'Salida de productos',
            'io' => 'O'
        ]);

        $product = factory(Product::class)->create([
            'product_header_id' => factory(ProductHeader::class)->create(['type'=>'P'])->id
        ]);

        $otherProduct = factory(Product::class)->create([
            'product_header_id' => factory(ProductHeader::class)->create(['type'=>'P'])->id
        ]);

        $notProduct = factory(Product::class)->create([
            'product_header_id' => factory(ProductHeader::class)->create(['type'=>'S'])->id
        ]);

        $provider = factory(Provider::class)->create();

        $user = factory(User::class)->create([
            'email' => 'admin@root.com',
            'password' => bcrypt('123456')
        ]);

        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

        $this->withHeaders(["Authorization" => 'Bearer '.$token])
            ->json('GET', '/api/transactions/create')
            ->assertStatus(200)
            ->assertExactJson([
                'providers' => [
                    [
                        'id' => $provider->id,
                        'name' => $provider->name,
                        'description' => $provider->description,
                        'created_at' => (string)$provider->created_at,
                        'deleted_at' => NULL,
                        'updated_at' => (string)$provider->updated_at
                    ]
                ],
                'types' => [
                    [
                        'id' => $type->id,
                        'name' => $type->name,
                        'description' => $type->description,
                        'io' => $type->io
                    ],
                    [
                        'id' => $otherType->id,
                        'name' => $otherType->name,
                        'description' => $otherType->description,
                        'io' => $otherType->io
                    ]
                ],
                'products' => [
                    [
                        'id' => $product->id,
                        'price' => $product->price,
                        'product_header_id' => $product->product_header_id,
                        'created_at' => (string)$product->created_at,
                        'updated_at' => (string)$product->updated_at,
                        'deleted_at' => NULL,
                        'definition' => [
                            'id' => $product->definition->id,
                            'name' => $product->definition->name,
                            'description' => $product->definition->description,
                            'type' => $product->definition->type,
                            'image' => NULL,
                            'created_at' => (string)$product->definition->created_at,
                            'updated_at' => (string)$product->definition->updated_at,
                            'deleted_at' => NULL
                        ]
                    ],
                    [
                        'id' => $otherProduct->id,
                        'price' => $otherProduct->price,
                        'product_header_id' => $otherProduct->product_header_id,
                        'created_at' => (string)$otherProduct->created_at,
                        'updated_at' => (string)$otherProduct->updated_at,
                        'deleted_at' => NULL,
                        'definition' => [
                            'id' => $otherProduct->definition->id,
                            'name' => $otherProduct->definition->name,
                            'description' => $otherProduct->definition->description,
                            'type' => $otherProduct->definition->type,
                            'image' => NULL,
                            'created_at' => (string)$otherProduct->definition->created_at,
                            'updated_at' => (string)$otherProduct->definition->updated_at,
                            'deleted_at' => NULL
                        ]
                    ]
                ]
            ]);

    }

    /** @test */
    public function sell_can_be_maded()
    {
        //$this->withoutExceptionHandling();

        $type = factory(TransactionType::class)->create([
            'name' => 'Recepción',
            'description' => 'Entrada de productos',
            'io' => 'I'
        ]);

        $otherType = factory(TransactionType::class)->create([
            'name' => 'Despacho',
            'description' => 'Salida de productos',
            'io' => 'O'
        ]);

        $sellType = factory(TransactionType::class)->create([
            'name' => 'Venta',
            'description' => 'Venta a un cliente',
            'io' => 'O',
            'sell' => true
        ]);

        $product = factory(Product::class)->create([
            'product_header_id' => factory(ProductHeader::class)->create(['type'=>'P'])->id
        ]);

        $otherProduct = factory(Product::class)->create([
            'product_header_id' => factory(ProductHeader::class)->create(['type'=>'P'])->id
        ]);

        $notProduct = factory(Product::class)->create([
            'product_header_id' => factory(ProductHeader::class)->create(['type'=>'S'])->id
        ]);

        $customer = factory(Customer::class)->create();

        $user = factory(User::class)->create([
            'email' => 'admin@root.com',
            'password' => bcrypt('123456')
        ]);

        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

        $this->withHeaders(["Authorization" => 'Bearer '.$token])
            ->json('POST', '/api/transactions/sales', [
                'customer' => $customer->id,
                'products' => [
                    [
                        'id' => $product->id,
                        'qty' => 5
                    ],
                    [
                        'id' => $otherProduct->id,
                        'qty' => 2
                    ]
                ],
                'description' => 'Sell transaction',
            ])->assertStatus(201);

        $this->assertDatabaseHas('transactions', [
            'customer_id' => $customer->id,
            'provider_id' => NULL,
            'description' => 'Sell transaction',
            'transaction_type_id' => $sellType->id
        ]);

        $this->assertDatabaseHas('inventories', [
            'transaction_id' => 1,
            'product_id' => $product->id,
            'qty' => 5,
        ]);

        $this->assertDatabaseHas('inventories', [
            'transaction_id' => 1,
            'product_id' => $otherProduct->id,
            'qty' => 2,
        ]);

    }

    /** @test */
    public function sales_can_be_listed()
    {
        //$this->withoutExceptionHandling();

        $type = factory(TransactionType::class)->create([
            'name' => 'Recepción',
            'description' => 'Entrada de productos',
            'io' => 'I'
        ]);

        $otherType = factory(TransactionType::class)->create([
            'name' => 'Despacho',
            'description' => 'Salida de productos',
            'io' => 'O'
        ]);

        $sellType = factory(TransactionType::class)->create([
            'name' => 'Venta',
            'description' => 'Venta a un cliente',
            'io' => 'O',
            'sell' => true
        ]);

        $product = factory(Product::class)->create([
            'product_header_id' => factory(ProductHeader::class)->create(['type'=>'P'])->id
        ]);

        $otherProduct = factory(Product::class)->create([
            'product_header_id' => factory(ProductHeader::class)->create(['type'=>'P'])->id
        ]);

        $notProduct = factory(Product::class)->create([
            'product_header_id' => factory(ProductHeader::class)->create(['type'=>'S'])->id
        ]);

        $customer = factory(Customer::class)->create();

        $user = factory(User::class)->create([
            'email' => 'admin@root.com',
            'password' => bcrypt('123456')
        ]);

        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);


        $transaction = new Transaction([
            'customer_id' => $customer->id,
            'description' => 'Sell transaction',
            'transaction_type_id' => $sellType->id
        ]);

        $transaction->save();

        $transaction->products()->saveMany([
            new Inventory([
                'product_id' => $product->id,
                'transaction_id' => $transaction->id,
                'qty' => 5
            ]),
            new Inventory([
                'product_id' => $otherProduct->id,
                'transaction_id' => $transaction->id,
                'qty' => 2
            ]),
        ]);

        $this->withHeaders(["Authorization" => 'Bearer '.$token])
            ->json('GET', '/api/transactions/sales')
            ->assertStatus(200)
            ->assertExactJson([
                'sales' => [
                    [
                        'id' => $transaction->id,
                        'description' => $transaction->description,
                        'customer_id' => $customer->id,
                        'provider_id' => NULL,
                        'customer' => [
                            'id' => $transaction->customer->id,
                            'names' => $transaction->customer->names,
                            'surnames' => $transaction->customer->surnames,
                            'identity_number' => $transaction->customer->identity_number,
                            'phone' => $transaction->customer->phone,
                            'email' => $transaction->customer->email,
                            'birthdate' => $transaction->customer->birthdate,
                            'created_at' => (string)$transaction->customer->created_at,
                            'updated_at' => (string)$transaction->customer->updated_at,
                            'deleted_at' => NULL
                        ],
                        'products' => [
                            [
                                'id' => $transaction->products[0]->id,
                                'product_id' => $transaction->products[0]->product_id,
                                'transaction_id' => $transaction->products[0]->transaction_id,
                                'qty' => $transaction->products[0]->qty,
                                'product' => [
                                    'id' => $transaction->products[0]->product->id,
                                    'price' => $transaction->products[0]->product->price,
                                    'product_header_id' => $transaction->products[0]->product->product_header_id,
                                    'definition' => [
                                        'id' => $transaction->products[0]->product->definition->id,
                                        'name' => $transaction->products[0]->product->definition->name,
                                        'description' => $transaction->products[0]->product->definition->description,
                                        'image' => NULL,
                                        'type' => 'P',
                                        'created_at' => (string)$transaction->products[0]->product->definition->created_at,
                                        'updated_at' => (string)$transaction->products[0]->product->definition->updated_at,
                                        'deleted_at' => NULL,
                                    ],
                                    'created_at' => (string)$transaction->products[0]->product->created_at,
                                    'updated_at' => (string)$transaction->products[0]->product->updated_at,
                                    'deleted_at' => NULL,
                                ],
                                'created_at' => (string)$transaction->products[0]->created_at,
                                'updated_at' => (string)$transaction->products[0]->updated_at,
                                'deleted_at' => NULL,
                            ],
                            [
                                'id' => $transaction->products[1]->id,
                                'product_id' => $transaction->products[1]->product_id,
                                'transaction_id' => $transaction->products[1]->transaction_id,
                                'qty' => $transaction->products[1]->qty,
                                'product' => [
                                    'id' => $transaction->products[1]->product->id,
                                    'price' => $transaction->products[1]->product->price,
                                    'product_header_id' => $transaction->products[1]->product->product_header_id,
                                    'definition' => [
                                        'id' => $transaction->products[1]->product->definition->id,
                                        'name' => $transaction->products[1]->product->definition->name,
                                        'description' => $transaction->products[1]->product->definition->description,
                                        'image' => NULL,
                                        'type' => 'P',
                                        'created_at' => (string)$transaction->products[1]->product->definition->created_at,
                                        'updated_at' => (string)$transaction->products[1]->product->definition->updated_at,
                                        'deleted_at' => NULL,
                                    ],
                                    'created_at' => (string)$transaction->products[1]->product->created_at,
                                    'updated_at' => (string)$transaction->products[1]->product->updated_at,
                                    'deleted_at' => NULL,
                                ],
                                'created_at' => (string)$transaction->products[1]->created_at,
                                'updated_at' => (string)$transaction->products[1]->updated_at,
                                'deleted_at' => NULL,
                            ]

                        ],
                        'transaction_type_id' => $sellType->id,
                        'created_at' => (string)$transaction->created_at,
                        'updated_at' => (string)$transaction->updated_at,
                        'deleted_at' => NULL,
                    ]
                ]
            ]);
    }


    /** @test */
    public function sales_create_data_can_be_listed()
    {
        //$this->withoutExceptionHandling();

        $type = factory(TransactionType::class)->create([
            'name' => 'Recepción',
            'description' => 'Entrada de productos',
            'io' => 'I'
        ]);

        $otherType = factory(TransactionType::class)->create([
            'name' => 'Despacho',
            'description' => 'Salida de productos',
            'io' => 'O'
        ]);

        $sellType = factory(TransactionType::class)->create([
            'name' => 'Venta',
            'description' => 'Venta a un cliente',
            'io' => 'O',
            'sell' => true
        ]);

        $product = factory(Product::class)->create([
            'product_header_id' => factory(ProductHeader::class)->create(['type'=>'P'])->id
        ]);

        $otherProduct = factory(Product::class)->create([
            'product_header_id' => factory(ProductHeader::class)->create(['type'=>'P'])->id
        ]);

        $notProduct = factory(Product::class)->create([
            'product_header_id' => factory(ProductHeader::class)->create(['type'=>'S'])->id
        ]);

        $customer = factory(Customer::class)->create();

        $user = factory(User::class)->create([
            'email' => 'admin@root.com',
            'password' => bcrypt('123456')
        ]);

        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

        $this->withHeaders(["Authorization" => 'Bearer '.$token])
            ->json('GET', '/api/transactions/sales/create')
            ->assertStatus(200)
            ->assertExactJson([
                'customers' => [
                    [
                        'id' => $customer->id,
                        'names' => $customer->names,
                        'surnames' => $customer->surnames,
                        'identity_number' => $customer->identity_number,
                        'phone' => $customer->phone,
                        'email' => $customer->email,
                        'birthdate' => $customer->birthdate,
                        'created_at' => (string)$customer->created_at,
                        'updated_at' => (string)$customer->updated_at,
                        'deleted_at' => NULL
                    ]
                ],
                'products' => [
                    [
                        'id' => $product->id,
                        'price' => $product->price,
                        'product_header_id' => $product->product_header_id,
                        'created_at' => (string)$product->created_at,
                        'updated_at' => (string)$product->updated_at,
                        'deleted_at' => NULL,
                        'definition' => [
                            'id' => $product->definition->id,
                            'name' => $product->definition->name,
                            'description' => $product->definition->description,
                            'type' => $product->definition->type,
                            'image' => NULL,
                            'created_at' => (string)$product->definition->created_at,
                            'updated_at' => (string)$product->definition->updated_at,
                            'deleted_at' => NULL
                        ]
                    ],
                    [
                        'id' => $otherProduct->id,
                        'price' => $otherProduct->price,
                        'product_header_id' => $otherProduct->product_header_id,
                        'created_at' => (string)$otherProduct->created_at,
                        'updated_at' => (string)$otherProduct->updated_at,
                        'deleted_at' => NULL,
                        'definition' => [
                            'id' => $otherProduct->definition->id,
                            'name' => $otherProduct->definition->name,
                            'description' => $otherProduct->definition->description,
                            'type' => $otherProduct->definition->type,
                            'image' => NULL,
                            'created_at' => (string)$otherProduct->definition->created_at,
                            'updated_at' => (string)$otherProduct->definition->updated_at,
                            'deleted_at' => NULL
                        ]
                    ]
                ]
            ]);

    }

}
