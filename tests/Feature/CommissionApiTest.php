<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Commission;
use App\Employee;
use App\Product;
use App\ProductHeader;

class CommissionApiTest extends TestCase
{
	use RefreshDatabase;

    /** @test */
	public function commission_create_data_can_be_listed() 
	{

		//$this->withoutExceptionHandling();

        $user = factory(User::class)->create([
            'email' => 'admin@root.com',
            'password' => bcrypt('123456')
        ]);

        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

        $employee = factory(Employee::class)->create();

        $service = factory(Product::class)->create([
        	'product_header_id' => factory(ProductHeader::class)->create([
        		'type' => 'S'
        	])->id
        ]);

        $notService = factory(Product::class)->create([
        	'product_header_id' => factory(ProductHeader::class)->create([
        		'type' => 'P'
        	])->id
        ]);

		$this->withHeaders(["Authorization" => 'Bearer '.$token])
		->json('GET', '/api/commissions/create')
		->assertStatus(200)
		->assertExactJson([
			'services' => [
				[
					'id' => $service->id,
					'price' => $service->price,
					'product_header_id' => $service->definition->id,
					'created_at' => (string)$service->created_at,
					'updated_at' => (string)$service->updated_at,
					'deleted_at' => NULL,
					'definition' => [
						'id' => $service->definition->id,
						'name' => $service->definition->name,
						'description' => $service->definition->description,
						'type' => 'S',
						'image' => NULL,
						'created_at' => (string)$service->definition->created_at,
						'updated_at' => (string)$service->definition->updated_at,
						'deleted_at' => NULL
					]
				]
			],
			'employees' => [
				[
					'id' => $employee->id,
					'names'=> $employee->names,
					'surnames'=> $employee->surnames,
					'identity_number'=> $employee->identity_number,
					'email'=> $employee->email,
					'phone'=> $employee->phone,
					'birthdate'=> $employee->birthdate,
					'profile_pic'=> $employee->profile_pic,
					'occupation_id'=> $employee->occupation_id,
					'occupation'=> [
						'id' => $employee->occupation->id,
						'name' => $employee->occupation->name,
						'description' => $employee->occupation->description
					],
					'created_at' => (string)$employee->created_at,
					'updated_at' => (string)$employee->updated_at,
					'deleted_at' => NULL
				]
			]
		]);
	}

    /** @test */
	public function one_commission_can_be_assigned_to_employee() {

		//$this->withoutExceptionHandling();

        $user = factory(User::class)->create([
            'email' => 'admin@root.com',
            'password' => bcrypt('123456')
        ]);

        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

        $employee = factory(Employee::class)->create();

        $service = factory(Product::class)->create([
        	'product_header_id' => factory(ProductHeader::class)->create([
        		'type' => 'S'
        	])->id
        ]);

		$this->withHeaders(["Authorization" => 'Bearer '.$token])
		->json('POST', '/api/commissions', [
			'commissions' => [
				[
					'employee' => $employee->id,
					'service' => $service->id,
					'percentage' => 30,
				]
			]
		])->assertStatus(201);

		$this->assertDatabaseHas('commissions', [
			'employee_id' => $employee->id,
			'service_id' => $service->id,
			'percentage' => 30
		]);

		$this->assertCount(1, Commission::get());
	}

    /** @test */
	public function one_commission_can_be_assigned_to_many_employees() {

		//$this->withoutExceptionHandling();

        $user = factory(User::class)->create([
            'email' => 'admin@root.com',
            'password' => bcrypt('123456')
        ]);

        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

        $employee = factory(Employee::class)->create();
        $secondEmployee = factory(Employee::class)->create();
        $thirdEmployee = factory(Employee::class)->create();

        $service = factory(Product::class)->create([
        	'product_header_id' => factory(ProductHeader::class)->create([
        		'type' => 'S'
        	])->id
        ]);

		$this->withHeaders(["Authorization" => 'Bearer '.$token])
		->json('POST', '/api/commissions', [
			'commissions' => [
				[
					'employee' => $employee->id,
					'service' => $service->id,
					'percentage' => 30,
				],
				[
					'employee' => $secondEmployee->id,
					'service' => $service->id,
					'percentage' => 10,
				],
				[
					'employee' => $thirdEmployee->id,
					'service' => $service->id,
					'percentage' => 15,
				],
			]
		])->assertStatus(201);

		$this->assertDatabaseHas('commissions', [
			'employee_id' => $employee->id,
			'service_id' => $service->id,
			'percentage' => 30
		]);

		$this->assertDatabaseHas('commissions', [
			'employee_id' => $secondEmployee->id,
			'service_id' => $service->id,
			'percentage' => 10
		]);

		$this->assertDatabaseHas('commissions', [
			'employee_id' => $thirdEmployee->id,
			'service_id' => $service->id,
			'percentage' => 15
		]);

		$this->assertCount(3, Commission::get());
	}	


    /** @test */
	public function many_commissions_can_be_assigned_to_one_employee() {

		//$this->withoutExceptionHandling();

        $user = factory(User::class)->create([
            'email' => 'admin@root.com',
            'password' => bcrypt('123456')
        ]);

        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

        $employee = factory(Employee::class)->create();
        $secondEmployee = factory(Employee::class)->create();
        $thirdEmployee = factory(Employee::class)->create();

        $service = factory(Product::class)->create([
        	'product_header_id' => factory(ProductHeader::class)->create([
        		'type' => 'S'
        	])->id
        ]);

        $secondService = factory(Product::class)->create([
        	'product_header_id' => factory(ProductHeader::class)->create([
        		'type' => 'S'
        	])->id
        ]);

        $thirdService = factory(Product::class)->create([
        	'product_header_id' => factory(ProductHeader::class)->create([
        		'type' => 'S'
        	])->id
        ]);

		$this->withHeaders(["Authorization" => 'Bearer '.$token])
		->json('POST', '/api/commissions', [
			'commissions' => [
				[
					'employee' => $employee->id,
					'service' => $service->id,
					'percentage' => 30,
				],
				[
					'employee' => $employee->id,
					'service' => $secondService->id,
					'percentage' => 10,
				],
				[
					'employee' => $employee->id,
					'service' => $thirdService->id,
					'percentage' => 15,
				],
			]
		])->assertStatus(201);

		$this->assertDatabaseHas('commissions', [
			'employee_id' => $employee->id,
			'service_id' => $service->id,
			'percentage' => 30
		]);

		$this->assertDatabaseHas('commissions', [
			'employee_id' => $employee->id,
			'service_id' => $secondService->id,
			'percentage' => 10
		]);

		$this->assertDatabaseHas('commissions', [
			'employee_id' => $employee->id,
			'service_id' => $thirdService->id,
			'percentage' => 15
		]);

		$this->assertCount(3, Commission::get());
	}

    /** @test */
	public function prevent_create_duplicated_commission() {

		//$this->withoutExceptionHandling();

        $user = factory(User::class)->create([
            'email' => 'admin@root.com',
            'password' => bcrypt('123456')
        ]);

        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

        $employee = factory(Employee::class)->create();

        $service = factory(Product::class)->create([
        	'product_header_id' => factory(ProductHeader::class)->create([
        		'type' => 'S'
        	])->id
        ]);

		$this->withHeaders(["Authorization" => 'Bearer '.$token])
		->json('POST', '/api/commissions', [
			'commissions' => [
				[
					'employee' => $employee->id,
					'service' => $service->id,
					'percentage' => 30,
				],
				[
					'employee' => $employee->id,
					'service' => $service->id,
					'percentage' => 10,
				],
				[
					'employee' => $employee->id,
					'service' => $service->id,
					'percentage' => 15,
				],
			]
		])->assertStatus(201);

		$this->assertDatabaseHas('commissions', [
			'employee_id' => $employee->id,
			'service_id' => $service->id,
			'percentage' => 30
		]);

		$this->assertCount(1, Commission::get());
	}

    /** @test */
	public function commissions_can_be_listed() {

		//$this->withoutExceptionHandling();

        $user = factory(User::class)->create([
            'email' => 'admin@root.com',
            'password' => bcrypt('123456')
        ]);

        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

        $employee = factory(Employee::class)->create();

        $service = factory(Product::class)->create([
        	'product_header_id' => factory(ProductHeader::class)->create([
        		'type' => 'S'
        	])->id
        ]);

        $commission = factory(Commission::class)->create([
        	'service_id' => $service->id,
        	'employee_id' => $employee->id,
        	'percentage' => 30
        ]);

		$this->withHeaders(["Authorization" => 'Bearer '.$token])
		->json('GET', '/api/commissions')
		->assertStatus(200)
		->assertExactJson([
			'commissions' => [
				[
					'id' => $commission->id,
					'service_id' => $service->id,
					'employee_id' => $employee->id,
					'created_at' => (string)$commission->created_at,
					'updated_at' => (string)$commission->updated_at,
					'deleted_at' => NULL,
					'service' => [
						'id' => $service->id,
						'price' => $service->price,
						'product_header_id' => $service->definition->id,
						'created_at' => (string)$service->created_at,
						'updated_at' => (string)$service->updated_at,
						'deleted_at' => NULL,
						'definition' => [
							'id' => $service->definition->id,
							'name' => $service->definition->name,
							'description' => $service->definition->description,
							'type' => 'S',
							'image' => NULL,
							'created_at' => (string)$service->definition->created_at,
							'updated_at' => (string)$service->definition->updated_at,
							'deleted_at' => NULL
						]
					],
					'employee' => [
						'id' => $employee->id,
						'names'=> $employee->names,
						'surnames'=> $employee->surnames,
						'identity_number'=> $employee->identity_number,
						'email'=> $employee->email,
						'phone'=> $employee->phone,
						'birthdate'=> $employee->birthdate,
						'profile_pic'=> $employee->profile_pic,
						'occupation_id'=> $employee->occupation_id,
						'occupation'=> [
							'id' => $employee->occupation->id,
							'name' => $employee->occupation->name,
							'description' => $employee->occupation->description
						],
						'created_at' => (string)$employee->created_at,
						'updated_at' => (string)$employee->updated_at,
						'deleted_at' => NULL
					],
					'percentage' => $commission->percentage
				]
			]
		]);
	}

    /** @test */
	public function one_commission_edit_data_can_be_listed() 
	{

		//$this->withoutExceptionHandling();

        $user = factory(User::class)->create([
            'email' => 'admin@root.com',
            'password' => bcrypt('123456')
        ]);

        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

        $employee = factory(Employee::class)->create();

        $service = factory(Product::class)->create([
        	'product_header_id' => factory(ProductHeader::class)->create([
        		'type' => 'S'
        	])->id
        ]);

        $notService = factory(Product::class)->create([
        	'product_header_id' => factory(ProductHeader::class)->create([
        		'type' => 'P'
        	])->id
        ]);

        $commission = factory(Commission::class)->create([
        	'service_id' => $service->id,
        	'employee_id' => $employee->id,
        	'percentage' => 30
        ]);

		$this->withHeaders(["Authorization" => 'Bearer '.$token])
		->json('GET', '/api/commissions/'.$commission->id.'/edit')
		->assertStatus(200)
		->assertExactJson([
			'services' => [
				[
					'id' => $service->id,
					'price' => $service->price,
					'product_header_id' => $service->definition->id,
					'created_at' => (string)$service->created_at,
					'updated_at' => (string)$service->updated_at,
					'deleted_at' => NULL,
					'definition' => [
						'id' => $service->definition->id,
						'name' => $service->definition->name,
						'description' => $service->definition->description,
						'type' => 'S',
						'image' => NULL,
						'created_at' => (string)$service->definition->created_at,
						'updated_at' => (string)$service->definition->updated_at,
						'deleted_at' => NULL
					]
				],

			],
			'employees' => [
				[
					'id' => $employee->id,
					'names'=> $employee->names,
					'surnames'=> $employee->surnames,
					'identity_number'=> $employee->identity_number,
					'email'=> $employee->email,
					'phone'=> $employee->phone,
					'birthdate'=> $employee->birthdate,
					'profile_pic'=> $employee->profile_pic,
					'occupation_id'=> $employee->occupation_id,
					'occupation'=> [
						'id' => $employee->occupation->id,
						'name' => $employee->occupation->name,
						'description' => $employee->occupation->description
					],
					'created_at' => (string)$employee->created_at,
					'updated_at' => (string)$employee->updated_at,
					'deleted_at' => NULL
				],
			],
			'commissions' => [
				[
					'id' => $commission->id,
					'service_id' => $service->id,
					'employee_id' => $employee->id,
					'created_at' => (string)$commission->created_at,
					'updated_at' => (string)$commission->updated_at,
					'deleted_at' => NULL,
					'service' => [
						'id' => $service->id,
						'price' => $service->price,
						'product_header_id' => $service->definition->id,
						'created_at' => (string)$service->created_at,
						'updated_at' => (string)$service->updated_at,
						'deleted_at' => NULL,
						'definition' => [
							'id' => $service->definition->id,
							'name' => $service->definition->name,
							'description' => $service->definition->description,
							'type' => 'S',
							'image' => NULL,
							'created_at' => (string)$service->definition->created_at,
							'updated_at' => (string)$service->definition->updated_at,
							'deleted_at' => NULL
						]
					],
					'employee' => [
						'id' => $employee->id,
						'names'=> $employee->names,
						'surnames'=> $employee->surnames,
						'identity_number'=> $employee->identity_number,
						'email'=> $employee->email,
						'phone'=> $employee->phone,
						'birthdate'=> $employee->birthdate,
						'profile_pic'=> $employee->profile_pic,
						'occupation_id'=> $employee->occupation_id,
						'occupation'=> [
							'id' => $employee->occupation->id,
							'name' => $employee->occupation->name,
							'description' => $employee->occupation->description
						],
						'created_at' => (string)$employee->created_at,
						'updated_at' => (string)$employee->updated_at,
						'deleted_at' => NULL
					],
					'percentage' => $commission->percentage
				],

			]
		]);
	}


    /** @test */
	public function many_commissions_edit_data_can_be_listed() 
	{

		$this->withoutExceptionHandling();

        $user = factory(User::class)->create([
            'email' => 'admin@root.com',
            'password' => bcrypt('123456')
        ]);

        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

        $employee = factory(Employee::class)->create();
        $secondEmployee = factory(Employee::class)->create();
        $thirdEmployee = factory(Employee::class)->create();

        $service = factory(Product::class)->create([
        	'product_header_id' => factory(ProductHeader::class)->create([
        		'type' => 'S'
        	])->id
        ]);

        $secondService = factory(Product::class)->create([
        	'product_header_id' => factory(ProductHeader::class)->create([
        		'type' => 'S'
        	])->id
        ]);

        $thirdService = factory(Product::class)->create([
        	'product_header_id' => factory(ProductHeader::class)->create([
        		'type' => 'S'
        	])->id
        ]);

        $notService = factory(Product::class)->create([
        	'product_header_id' => factory(ProductHeader::class)->create([
        		'type' => 'P'
        	])->id
        ]);

        $commission = factory(Commission::class)->create([
        	'service_id' => $service->id,
        	'employee_id' => $employee->id,
        	'percentage' => 30
        ]);

        $secondCommission = factory(Commission::class)->create([
        	'service_id' => $secondService->id,
        	'employee_id' => $secondEmployee->id,
        	'percentage' => 30
        ]);

        $thirdCommission = factory(Commission::class)->create([
        	'service_id' => $thirdService->id,
        	'employee_id' => $thirdEmployee->id,
        	'percentage' => 30
        ]);

        $ids = implode(',', [
        	$commission->id,
        	$secondCommission->id,
        	$thirdCommission->id
        ]);

		$this->withHeaders(["Authorization" => 'Bearer '.$token])
		->json('GET', '/api/commissions/'.$ids.'/edit')
		->assertStatus(200)
		->assertExactJson([
			'services' => [
				[
					'id' => $service->id,
					'price' => $service->price,
					'product_header_id' => $service->definition->id,
					'created_at' => (string)$service->created_at,
					'updated_at' => (string)$service->updated_at,
					'deleted_at' => NULL,
					'definition' => [
						'id' => $service->definition->id,
						'name' => $service->definition->name,
						'description' => $service->definition->description,
						'type' => 'S',
						'image' => NULL,
						'created_at' => (string)$service->definition->created_at,
						'updated_at' => (string)$service->definition->updated_at,
						'deleted_at' => NULL
					]
				],
				[
					'id' => $secondService->id,
					'price' => $secondService->price,
					'product_header_id' => $secondService->definition->id,
					'created_at' => (string)$secondService->created_at,
					'updated_at' => (string)$secondService->updated_at,
					'deleted_at' => NULL,
					'definition' => [
						'id' => $secondService->definition->id,
						'name' => $secondService->definition->name,
						'description' => $secondService->definition->description,
						'type' => 'S',
						'image' => NULL,
						'created_at' => (string)$secondService->definition->created_at,
						'updated_at' => (string)$secondService->definition->updated_at,
						'deleted_at' => NULL
					]
				],
				[
					'id' => $thirdService->id,
					'price' => $thirdService->price,
					'product_header_id' => $thirdService->definition->id,
					'created_at' => (string)$thirdService->created_at,
					'updated_at' => (string)$thirdService->updated_at,
					'deleted_at' => NULL,
					'definition' => [
						'id' => $thirdService->definition->id,
						'name' => $thirdService->definition->name,
						'description' => $thirdService->definition->description,
						'type' => 'S',
						'image' => NULL,
						'created_at' => (string)$thirdService->definition->created_at,
						'updated_at' => (string)$thirdService->definition->updated_at,
						'deleted_at' => NULL
					]
				],
			],
			'employees' => [
				[
					'id' => $employee->id,
					'names'=> $employee->names,
					'surnames'=> $employee->surnames,
					'identity_number'=> $employee->identity_number,
					'email'=> $employee->email,
					'phone'=> $employee->phone,
					'birthdate'=> $employee->birthdate,
					'profile_pic'=> $employee->profile_pic,
					'occupation_id'=> $employee->occupation_id,
					'occupation'=> [
						'id' => $employee->occupation->id,
						'name' => $employee->occupation->name,
						'description' => $employee->occupation->description
					],
					'created_at' => (string)$employee->created_at,
					'updated_at' => (string)$employee->updated_at,
					'deleted_at' => NULL
				],
				[
					'id' => $secondEmployee->id,
					'names'=> $secondEmployee->names,
					'surnames'=> $secondEmployee->surnames,
					'identity_number'=> $secondEmployee->identity_number,
					'email'=> $secondEmployee->email,
					'phone'=> $secondEmployee->phone,
					'birthdate'=> $secondEmployee->birthdate,
					'profile_pic'=> $secondEmployee->profile_pic,
					'occupation_id'=> $secondEmployee->occupation_id,
					'occupation'=> [
						'id' => $secondEmployee->occupation->id,
						'name' => $secondEmployee->occupation->name,
						'description' => $secondEmployee->occupation->description
					],
					'created_at' => (string)$secondEmployee->created_at,
					'updated_at' => (string)$secondEmployee->updated_at,
					'deleted_at' => NULL
				],
				[
					'id' => $thirdEmployee->id,
					'names'=> $thirdEmployee->names,
					'surnames'=> $thirdEmployee->surnames,
					'identity_number'=> $thirdEmployee->identity_number,
					'email'=> $thirdEmployee->email,
					'phone'=> $thirdEmployee->phone,
					'birthdate'=> $thirdEmployee->birthdate,
					'profile_pic'=> $thirdEmployee->profile_pic,
					'occupation_id'=> $thirdEmployee->occupation_id,
					'occupation'=> [
						'id' => $thirdEmployee->occupation->id,
						'name' => $thirdEmployee->occupation->name,
						'description' => $thirdEmployee->occupation->description
					],
					'created_at' => (string)$thirdEmployee->created_at,
					'updated_at' => (string)$thirdEmployee->updated_at,
					'deleted_at' => NULL
				]
			],
			'commissions' => [
				[
					'id' => $commission->id,
					'service_id' => $service->id,
					'employee_id' => $employee->id,
					'created_at' => (string)$commission->created_at,
					'updated_at' => (string)$commission->updated_at,
					'deleted_at' => NULL,
					'service' => [
						'id' => $service->id,
						'price' => $service->price,
						'product_header_id' => $service->definition->id,
						'created_at' => (string)$service->created_at,
						'updated_at' => (string)$service->updated_at,
						'deleted_at' => NULL,
						'definition' => [
							'id' => $service->definition->id,
							'name' => $service->definition->name,
							'description' => $service->definition->description,
							'type' => 'S',
							'image' => NULL,
							'created_at' => (string)$service->definition->created_at,
							'updated_at' => (string)$service->definition->updated_at,
							'deleted_at' => NULL
						]
					],
					'employee' => [
						'id' => $employee->id,
						'names'=> $employee->names,
						'surnames'=> $employee->surnames,
						'identity_number'=> $employee->identity_number,
						'email'=> $employee->email,
						'phone'=> $employee->phone,
						'birthdate'=> $employee->birthdate,
						'profile_pic'=> $employee->profile_pic,
						'occupation_id'=> $employee->occupation_id,
						'occupation'=> [
							'id' => $employee->occupation->id,
							'name' => $employee->occupation->name,
							'description' => $employee->occupation->description
						],
						'created_at' => (string)$employee->created_at,
						'updated_at' => (string)$employee->updated_at,
						'deleted_at' => NULL
					],
					'percentage' => $commission->percentage
				],
				[
					'id' => $secondCommission->id,
					'service_id' => $secondService->id,
					'employee_id' => $secondEmployee->id,
					'created_at' => (string)$secondCommission->created_at,
					'updated_at' => (string)$secondCommission->updated_at,
					'deleted_at' => NULL,
					'service' => [
						'id' => $secondService->id,
						'price' => $secondService->price,
						'product_header_id' => $secondService->definition->id,
						'created_at' => (string)$secondService->created_at,
						'updated_at' => (string)$secondService->updated_at,
						'deleted_at' => NULL,
						'definition' => [
							'id' => $secondService->definition->id,
							'name' => $secondService->definition->name,
							'description' => $secondService->definition->description,
							'type' => 'S',
							'image' => NULL,
							'created_at' => (string)$secondService->definition->created_at,
							'updated_at' => (string)$secondService->definition->updated_at,
							'deleted_at' => NULL
						]
					],
					'employee' => [
						'id' => $secondEmployee->id,
						'names'=> $secondEmployee->names,
						'surnames'=> $secondEmployee->surnames,
						'identity_number'=> $secondEmployee->identity_number,
						'email'=> $secondEmployee->email,
						'phone'=> $secondEmployee->phone,
						'birthdate'=> $secondEmployee->birthdate,
						'profile_pic'=> $secondEmployee->profile_pic,
						'occupation_id'=> $secondEmployee->occupation_id,
						'occupation'=> [
							'id' => $secondEmployee->occupation->id,
							'name' => $secondEmployee->occupation->name,
							'description' => $secondEmployee->occupation->description
						],
						'created_at' => (string)$secondEmployee->created_at,
						'updated_at' => (string)$secondEmployee->updated_at,
						'deleted_at' => NULL
					],
					'percentage' => $secondCommission->percentage
				],
				[
					'id' => $thirdCommission->id,
					'service_id' => $thirdService->id,
					'employee_id' => $thirdEmployee->id,
					'created_at' => (string)$thirdCommission->created_at,
					'updated_at' => (string)$thirdCommission->updated_at,
					'deleted_at' => NULL,
					'service' => [
						'id' => $thirdService->id,
						'price' => $thirdService->price,
						'product_header_id' => $thirdService->definition->id,
						'created_at' => (string)$thirdService->created_at,
						'updated_at' => (string)$thirdService->updated_at,
						'deleted_at' => NULL,
						'definition' => [
							'id' => $thirdService->definition->id,
							'name' => $thirdService->definition->name,
							'description' => $thirdService->definition->description,
							'type' => 'S',
							'image' => NULL,
							'created_at' => (string)$thirdService->definition->created_at,
							'updated_at' => (string)$thirdService->definition->updated_at,
							'deleted_at' => NULL
						]
					],
					'employee' => [
						'id' => $thirdEmployee->id,
						'names'=> $thirdEmployee->names,
						'surnames'=> $thirdEmployee->surnames,
						'identity_number'=> $thirdEmployee->identity_number,
						'email'=> $thirdEmployee->email,
						'phone'=> $thirdEmployee->phone,
						'birthdate'=> $thirdEmployee->birthdate,
						'profile_pic'=> $thirdEmployee->profile_pic,
						'occupation_id'=> $thirdEmployee->occupation_id,
						'occupation'=> [
							'id' => $thirdEmployee->occupation->id,
							'name' => $thirdEmployee->occupation->name,
							'description' => $thirdEmployee->occupation->description
						],
						'created_at' => (string)$thirdEmployee->created_at,
						'updated_at' => (string)$thirdEmployee->updated_at,
						'deleted_at' => NULL
					],
					'percentage' => $thirdCommission->percentage
				]
			]
		]);
	}


    /** @test */
	public function commission_can_be_updated() {

		$this->withoutExceptionHandling();

        $user = factory(User::class)->create([
            'email' => 'admin@root.com',
            'password' => bcrypt('123456')
        ]);

        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

        $employee = factory(Employee::class)->create();

        $service = factory(Product::class)->create([
        	'product_header_id' => factory(ProductHeader::class)->create([
        		'type' => 'S'
        	])->id
        ]);

        $commission = factory(Commission::class)->create([
        	'service_id' => $service->id,
        	'employee_id' => $employee->id,
        	'percentage' => 30
        ]);

		$this->withHeaders(["Authorization" => 'Bearer '.$token])
		->json('PUT', '/api/commissions/', [
			'commissions' => [
				[
					'id' => $commission->id,
					'employee' => $employee->id,
					'service' => $service->id,
					'percentage' => 10,
				]
			]
		])->assertStatus(200);

		$this->assertDatabaseHas('commissions', [
			'employee_id' => $employee->id,
			'service_id' => $service->id,
			'percentage' => 10
		]);

		$this->assertCount(1, Commission::get());
	}


    /** @test */
	public function many_commissions_can_be_updated() {

		$this->withoutExceptionHandling();

        $user = factory(User::class)->create([
            'email' => 'admin@root.com',
            'password' => bcrypt('123456')
        ]);

        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

        $employee = factory(Employee::class)->create();
        $secondEmployee = factory(Employee::class)->create();

        $service = factory(Product::class)->create([
        	'product_header_id' => factory(ProductHeader::class)->create([
        		'type' => 'S'
        	])->id
        ]);

        $secondService = factory(Product::class)->create([
        	'product_header_id' => factory(ProductHeader::class)->create([
        		'type' => 'S'
        	])->id
        ]);

        $commission = factory(Commission::class)->create([
        	'service_id' => $service->id,
        	'employee_id' => $employee->id,
        	'percentage' => 30
        ]);

        $secondCommission = factory(Commission::class)->create([
        	'service_id' => $secondService->id,
        	'employee_id' => $employee->id,
        	'percentage' => 30
        ]);

        $thirdCommission = factory(Commission::class)->create([
        	'service_id' => $secondService->id,
        	'employee_id' => $secondEmployee->id,
        	'percentage' => 30
        ]);

		$this->withHeaders(["Authorization" => 'Bearer '.$token])
		->json('PUT', '/api/commissions/', [
			'commissions' => [
				[
					'id' => $commission->id,
					'employee' => $employee->id,
					'service' => $service->id,
					'percentage' => 10,
				],
				[
					'id' => $secondCommission->id,
					'employee' => $employee->id,
					'service' => $secondService->id,
					'percentage' => 10,
				],
				[
					'id' => $thirdCommission->id,
					'employee' => $secondEmployee->id,
					'service' => $secondService->id,
					'percentage' => 10,
				],
			]
		])->assertStatus(200);

		$this->assertDatabaseHas('commissions', [
			'employee_id' => $employee->id,
			'service_id' => $service->id,
			'percentage' => 10
		]);

		$this->assertCount(3, Commission::get());
	}


}
