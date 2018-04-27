<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Customer;
use Illuminate\Support\Facades\DB;

class CustomersApiTest extends TestCase
{
	use RefreshDatabase;

	/** @test */
	public function customer_can_be_created() {

        $user = factory(User::class)->create([
            'email' => 'admin@root.com',
            'password' => bcrypt('123456')
        ]);

        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

		$this->withHeaders(["Authorization" => 'Bearer '.$token])
		->json('POST', '/api/customers', [
			'names' => 'Franco',
			'surnames' => 'Colmenarez',
			'identity_number' => 25896369,
			'email' => 'a@a.com',
			'phone' => '+123456',
			'birthday' => '12/17/1997'
		])->assertStatus(201);

		$this->assertDatabaseHas('customers', [
			'names' => 'Franco',
			'surnames' => 'Colmenarez',
			'identity_number' => 25896369,
			'email' => 'a@a.com',
			'phone' => '+123456',
		]);
	}

	/** @test */
	public function customer_can_be_edited() {

        $user = factory(User::class)->create([
            'email' => 'admin@root.com',
            'password' => bcrypt('123456')
        ]);

        $customer = factory(Customer::class)->create();

        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

		$this->withHeaders(["Authorization" => 'Bearer '.$token])
		->json('PUT', '/api/customers/'.$customer->id, [
			'names' => 'Franco',
			'surnames' => 'Colmenarez',
			'identity_number' => 25896369,
			'email' => 'a@a.com',
			'phone' => '+123456'
		])->assertStatus(200);

		$this->assertDatabaseHas('customers', [
			'id' => $customer->id,
			'names' => 'Franco',
			'surnames' => 'Colmenarez',
			'identity_number' => 25896369,
			'email' => 'a@a.com',
			'phone' => '+123456',
		]);
	}

	/** @test */
	public function customers_can_be_listed() {

        $user = factory(User::class)->create([
            'email' => 'admin@root.com',
            'password' => bcrypt('123456')
        ]);

        $customer = factory(Customer::class)->create();

        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

		$this->withHeaders(["Authorization" => 'Bearer '.$token])
			->json('GET', '/api/customers/')
			->assertStatus(200)
			->assertExactJson([
				'customers' => [
					[
						'id' => $customer->id,
						'names' => $customer->names,
						'surnames' => $customer->surnames,
						'identity_number' => (int)$customer->identity_number,
						'email' => $customer->email,
						'phone' => $customer->phone,
						'birthdate' => $customer->birthdate,
						'created_at' => (string)$customer->created_at,
						'deleted_at' => NULL,
						'updated_at' => (string)$customer->updated_at
					]
				]
			]);
	}

	/** @test */
	public function one_customer_can_be_finded()
	{
        $user = factory(User::class)->create([
            'email' => 'admin@root.com',
            'password' => bcrypt('123456')
        ]);

        $customer = factory(Customer::class)->create();

        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

		$this->withHeaders(["Authorization" => 'Bearer '.$token])
			->json('GET', '/api/customers/'.$customer->id)
			->assertStatus(200)
			->assertExactJson([
				'customer' => [
					'id' => $customer->id,
					'names' => $customer->names,
					'surnames' => $customer->surnames,
					'identity_number' => (int)$customer->identity_number,
					'email' => $customer->email,
					'phone' => $customer->phone,
					'birthdate' => $customer->birthdate,
					'created_at' => (string)$customer->created_at,
					'deleted_at' => NULL,
					'updated_at' => (string)$customer->updated_at
				]
			]);
	}

	/** @test */
	public function customer_edit_data_can_be_finded()
	{
        $user = factory(User::class)->create([
            'email' => 'admin@root.com',
            'password' => bcrypt('123456')
        ]);

        $customer = factory(Customer::class)->create();

        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

		$this->withHeaders(["Authorization" => 'Bearer '.$token])
			->json('GET', '/api/customers/'.$customer->id.'/edit')
			->assertStatus(200)
			->assertExactJson([
				'customer' => [
					'id' => $customer->id,
					'names' => $customer->names,
					'surnames' => $customer->surnames,
					'identity_number' => (int)$customer->identity_number,
					'email' => $customer->email,
					'phone' => $customer->phone,
					'birthdate' => $customer->birthdate,
					'created_at' => (string)$customer->created_at,
					'deleted_at' => NULL,
					'updated_at' => (string)$customer->updated_at
				]
			]);
	}

}
