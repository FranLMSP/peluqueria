<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Customer;
use App\Occupation;
use App\Employee;
use App\Product;
use App\ProductHeader;
use App\CalendarStatus;
use App\Calendar;

class CalendarApiTest extends TestCase
{
	use RefreshDatabase;

    /** @test */
	public function one_appointment_can_be_saved_with_new_customer() 
	{

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

        $notService = factory(Product::class)->create([
        	'product_header_id' => factory(ProductHeader::class)->create([
        		'type' => 'P'
        	])->id
        ]);

        $state = factory(CalendarStatus::class)->create();

		$this->withHeaders(["Authorization" => 'Bearer '.$token])
		->json('POST', '/api/calendar/', [
			'customer' => [
				'names' => 'Franco',
				'surnames' => 'Colmenarez',
				'identity_number' => 25896369,
				'email' => 'a@a.com',
				'phone' => ''
			],
			'customer_id' => NULL,
			'service_id' => $service->id,
			'employee_id' => $employee->id,
			'date' => '2018-05-22 20:00:00',
			'notes' => 'this is an observation',
			'status_id' => $state->id
		])
		->assertStatus(201);

		$this->assertDatabaseHas('calendar', [
			'customer_id' => 1,
			'notes' => 'this is an observation',
			'status_id' => $state->id
		]);

		$this->assertDatabaseHas('customers', [
			'names' => 'Franco',
			'surnames' => 'Colmenarez',
			'identity_number' => 25896369,
			'email' => 'a@a.com'
		]);
	}

    /** @test */
	public function one_appointment_can_be_updated_with_new_customer() 
	{

		$this->withoutExceptionHandling();

        $user = factory(User::class)->create([
            'email' => 'admin@root.com',
            'password' => bcrypt('123456')
        ]);

        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

        $employee = factory(Employee::class)->create();

        $customer = factory(Customer::class)->create();

        $newEmployee = factory(Employee::class)->create();

        $service = factory(Product::class)->create([
        	'product_header_id' => factory(ProductHeader::class)->create([
        		'type' => 'S'
        	])->id
        ]);

        $newService = factory(Product::class)->create([
        	'product_header_id' => factory(ProductHeader::class)->create([
        		'type' => 'S'
        	])->id
        ]);

        $notService = factory(Product::class)->create([
        	'product_header_id' => factory(ProductHeader::class)->create([
        		'type' => 'P'
        	])->id
        ]);

        $state = factory(CalendarStatus::class)->create();
        $newState = factory(CalendarStatus::class)->create();

        $appointment = factory(Calendar::class)->create([
        	'customer_id' => NULL,
			'service_id' => $service->id,
			'employee_id' => $employee->id,
			'status_id' => $state->id
        ]);

		$this->withHeaders(["Authorization" => 'Bearer '.$token])
		->json('PUT', '/api/calendar/'.$appointment->id, [
			'customer' => [
				'names' => 'Franco',
				'surnames' => 'Colmenarez',
				'identity_number' => 25896369,
				'email' => 'a@a.com',
				'phone' => ''
			],
			'customer_id' => NULL,
			'service_id' => $newService->id,
			'employee_id' => $newEmployee->id,
			'date' => '2018-05-22 20:00:00',
			'notes' => 'this is an observation',
			'status_id' => $newState->id
		])
		->assertStatus(200);

		$this->assertDatabaseHas('calendar', [
			'customer_id' => 2,
			'service_id' => $newService->id,
			'employee_id' => $newEmployee->id,
			'notes' => 'this is an observation',
			'status_id' => $newState->id
		]);

		$this->assertDatabaseHas('customers', [
			'id' => 2,
			'names' => 'Franco',
			'surnames' => 'Colmenarez',
			'identity_number' => 25896369,
			'email' => 'a@a.com'
		]);
	}

    /** @test */
	public function one_appointment_can_be_updated_with_existent_customer() 
	{

		$this->withoutExceptionHandling();

        $user = factory(User::class)->create([
            'email' => 'admin@root.com',
            'password' => bcrypt('123456')
        ]);

        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

        $employee = factory(Employee::class)->create();

        $customer = factory(Customer::class)->create();
        $newCustomer = factory(Customer::class)->create();

        $newEmployee = factory(Employee::class)->create();

        $service = factory(Product::class)->create([
        	'product_header_id' => factory(ProductHeader::class)->create([
        		'type' => 'S'
        	])->id
        ]);

        $newService = factory(Product::class)->create([
        	'product_header_id' => factory(ProductHeader::class)->create([
        		'type' => 'S'
        	])->id
        ]);

        $notService = factory(Product::class)->create([
        	'product_header_id' => factory(ProductHeader::class)->create([
        		'type' => 'P'
        	])->id
        ]);

        $state = factory(CalendarStatus::class)->create();
        $newState = factory(CalendarStatus::class)->create();

        $appointment = factory(Calendar::class)->create([
        	'customer_id' => NULL,
			'service_id' => $service->id,
			'employee_id' => $employee->id,
			'status_id' => $state->id
        ]);

		$this->withHeaders(["Authorization" => 'Bearer '.$token])
		->json('PUT', '/api/calendar/'.$appointment->id, [
			'customer' => [
				'names' => 'Franco',
				'surnames' => 'Colmenarez',
				'identity_number' => 25896369,
				'email' => 'a@a.com',
				'phone' => ''
			],
			'customer_id' => $newCustomer->id,
			'service_id' => $newService->id,
			'employee_id' => $newEmployee->id,
			'date' => '2018-05-22 20:00:00',
			'notes' => 'this is an observation',
			'status_id' => $newState->id
		])
		->assertStatus(200);

		$this->assertDatabaseHas('calendar', [
			'customer_id' => 2,
			'service_id' => $newService->id,
			'employee_id' => $newEmployee->id,
			'notes' => 'this is an observation',
			'status_id' => $newState->id
		]);

		$this->assertDatabaseMissing('customers', [
			'id' => 2,
			'names' => 'Franco',
			'surnames' => 'Colmenarez',
			'identity_number' => 25896369,
			'email' => 'a@a.com'
		]);
	}

    /** @test */
	public function one_appointment_can_be_saved_with_existing_customer() 
	{

		$this->withoutExceptionHandling();

        $user = factory(User::class)->create([
            'email' => 'admin@root.com',
            'password' => bcrypt('123456')
        ]);

        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

        $employee = factory(Employee::class)->create();

        $customer = factory(Customer::class)->create();

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

        $state = factory(CalendarStatus::class)->create();

		$this->withHeaders(["Authorization" => 'Bearer '.$token])
		->json('POST', '/api/calendar/', [
			'customer' => [
				'names' => '1',
				'surnames' => '1',
				'identity_number' => '1',
				'email' => 'a@a.com',
				'phone' => '1'
			],
			'customer_id' => $customer->id,
			'service_id' => $service->id,
			'employee_id' => $employee->id,
			'date' => '2018-05-22 20:00:00',
			'notes' => 'this is an observation',
			'status_id' => $state->id
		])
		->assertStatus(201);

		$this->assertDatabaseHas('calendar', [
			'customer_id' => $customer->id,
			'notes' => 'this is an observation',
			'status_id' => $state->id
		]);

	}

    /** @test */
	public function appointment_create_data_can_be_listed() 
	{

		$this->withoutExceptionHandling();

        $user = factory(User::class)->create([
            'email' => 'admin@root.com',
            'password' => bcrypt('123456')
        ]);

        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

        $employee = factory(Employee::class)->create([
        	'occupation_id' => factory(Occupation::class)->create()->id
        ]);

        $customer = factory(Customer::class)->create();

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

        $status = factory(CalendarStatus::class)->create();

		$this->withHeaders(["Authorization" => 'Bearer '.$token])
		->json('GET', '/api/calendar/create')
		->assertStatus(200)
		->assertExactJson([
			'customers' => [
				[
					'id' => $customer->id,
					'names' => $customer->names,
					'surnames' => $customer->surnames,
					'identity_number' => $customer->identity_number,
					'email' => $customer->email,
					'phone' => $customer->phone
				]
			],
			'services' => [
				[
					'id' => $service->id,
					'product_header_id' => $service->product_header_id,
					'definition' => [
						'id' => $service->definition->id,
						'name' => $service->definition->name,
						'description' => $service->definition->description
					]
				]
			],
			'statuses' => [
				[
					'id' => $status->id,
					'name'=> $status->name,
					'description'=> $status->description,
					'active'=> true
				]
			],
			'employees' => [
				[
					'id' => $employee->id,
					'names' => $employee->names,
					'surnames' => $employee->surnames,
					'identity_number' => $employee->identity_number,
					'occupation_id' => $employee->occupation_id,
					'occupation' => [
						'id' => $employee->occupation->id,
						'name' => $employee->occupation->name,
						'description' => $employee->occupation->description,
					]
				]
			]
		]);

	}

    /** @test */
	public function appointment_month_data_can_be_listed() 
	{

		$this->withoutExceptionHandling();

        $user = factory(User::class)->create([
            'email' => 'admin@root.com',
            'password' => bcrypt('123456')
        ]);

        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

        $employee = factory(Employee::class)->create([
        	'occupation_id' => factory(Occupation::class)->create()->id
        ]);

        $customer = factory(Customer::class)->create();

        $service = factory(Product::class)->create([
        	'active' => true,
        	'product_header_id' => factory(ProductHeader::class)->create([
        		'type' => 'S'
        	])->id
        ]);

        $notService = factory(Product::class)->create([
        	'product_header_id' => factory(ProductHeader::class)->create([
        		'type' => 'P'
        	])->id
        ]);

        $status = factory(CalendarStatus::class)->create([
        	'active' => true
        ]);

        $calendar = factory(Calendar::class)->create([
        	'customer_id' => $customer->id,
        	'service_id' => $service->id,
        	'employee_id' => $employee->id,
        	'status_id' => $status->id,
        	'date' => '2018-05-22 20:00:00'
        ]);

        $farCalendar = factory(Calendar::class)->create([
        	'customer_id' => $customer->id,
        	'service_id' => $service->id,
        	'employee_id' => $employee->id,
        	'status_id' => $status->id,
        	'date' => '2018-03-22 20:00:00'
        ]);

		$this->withHeaders(["Authorization" => 'Bearer '.$token])
		->json('GET', '/api/calendar/month/2018-5')
		->assertStatus(200)
		->assertExactJson([
			'calendar' => [
				[
					'id' => $calendar->id,
					'date' => $calendar->date,
					'notes' => $calendar->notes,
					'status_id' => $status->id,
					'service_id' => $service->id,
					'employee_id' => $employee->id,
					'customer_id' => $customer->id,
					'created_at' => (string)$calendar->created_at,
					'updated_at' => (string)$calendar->updated_at,
					'customer' => [
						'id' => $customer->id,
						'names' => $customer->names,
						'surnames' => $customer->surnames,
						'identity_number' => $customer->identity_number,
						'phone' => $customer->phone,
						'email' => $customer->email,
						'birthdate' => $customer->birthdate,
						'created_at' => (string)$customer->created_at,
						'updated_at' => (string)$customer->updated_at,
						'deleted_at' => NULL,
					],
					'employee' => [
						'id' => $employee->id,
						'names' => $employee->names,
						'surnames' => $employee->surnames,
						'identity_number' => $employee->identity_number,
						'phone' => $employee->phone,
						'email' => $employee->email,
						'birthdate' => $employee->birthdate,
						'profile_pic' => NULL,
						'occupation_id' => $employee->occupation_id,
						'created_at' => (string)$employee->created_at,
						'updated_at' => (string)$employee->updated_at,
						'deleted_at' => NULL,
						'occupation' => [
							'id' => $employee->occupation->id,
							'name' => $employee->occupation->name,
							'description' => $employee->occupation->description
						]
					],
					'status' => [
						'id' => $status->id,
						'name' => $status->name,
						'description' => $status->description,
						'icon' => null,
						'active' => true,
					],
					'service' => [
						'id' => $service->id,
						'price' => $service->price,
						'product_header_id' => $service->product_header_id,
						'created_at' => (string)$calendar->created_at,
						'updated_at' => (string)$calendar->updated_at,
						'deleted_at' => NULL,
						'definition' => [
							'id'=>$service->definition->id,
							'name' => $service->definition->name,
							'description' => $service->definition->description,
							'type' => 'S',
							'image' => NULL,
							'created_at' => (string)$service->definition->created_at,
							'updated_at' => (string)$service->definition->updated_at,
							'deleted_at' => NULL,
						]
					]
				]
			]
		]);

	}

}
