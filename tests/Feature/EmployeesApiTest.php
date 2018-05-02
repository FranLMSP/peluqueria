<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Occupation;
use App\Employee;

class EmployeesApiTest extends TestCase
{

	use RefreshDatabase;

	/** @test */
    public function employee_can_be_created()
    {
    	//$this->withoutExceptionHandling();

        $user = factory(User::class)->create([
            'email' => 'admin@root.com',
            'password' => bcrypt('123456')
        ]);

        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);
        $occupation = factory(Occupation::class)->create();

		$this->withHeaders(["Authorization" => 'Bearer '.$token])
		->json('POST', '/api/employees', [
			'names' => 'Franco',
			'surnames' => 'Colmenarez',
			'identity_number' => 25896369,
			'email' => 'a@a.com',
			'phone' => '+123456',
			'birthdate' => '12/17/1997',
			'occupation' => $occupation->id
		])->assertStatus(201);

		$this->assertDatabaseHas('employees', [
			'names' => 'Franco',
			'surnames' => 'Colmenarez',
			'identity_number' => 25896369,
			'email' => 'a@a.com',
			'phone' => '+123456',
			'occupation_id' => $occupation->id
		]);

   }


	/** @test */
    public function employee_can_be_updated()
    {
    	//$this->withoutExceptionHandling();

        $user = factory(User::class)->create([
            'email' => 'admin@root.com',
            'password' => bcrypt('123456')
        ]);

        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);
        $employee = factory(Employee::class)->create();
        $occupation = factory(Occupation::class)->create();

		$this->withHeaders(["Authorization" => 'Bearer '.$token])
		->json('PUT', '/api/employees/'.$employee->id, [
			'names' => 'Franco E',
			'surnames' => 'Colmenarez E',
			'identity_number' => 25896369,
			'email' => 'e@e.com',
			'phone' => '+123456',
			'birthdate' => '12/17/1997',
			'occupation' => $occupation->id
		])->assertStatus(200);

		$this->assertDatabaseHas('employees', [
			'id' => $employee->id,
			'names' => 'Franco E',
			'surnames' => 'Colmenarez E',
			'identity_number' => 25896369,
			'email' => 'e@e.com',
			'phone' => '+123456',
			'occupation_id' => $occupation->id
		]);

    }

    /** @test */
    public function employee_create_data_can_be_listed()
    {
    	//$this->withoutExceptionHandling();

        $user = factory(User::class)->create([
            'email' => 'admin@root.com',
            'password' => bcrypt('123456')
        ]);

        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

        $occupation = factory(Occupation::class)->create();

		$this->withHeaders(["Authorization" => 'Bearer '.$token])
			->json('GET', '/api/employees/create')
			->assertStatus(200)
			->assertExactJson([
				'occupations' => [
					[
						'id' => $occupation->id,
						'name' => $occupation->name,
						'description' => $occupation->description
					]
				]
		]);
    }

    /** @test */
    public function employee_edit_data_can_be_listed()
    {
    	//$this->withoutExceptionHandling();

        $user = factory(User::class)->create([
            'email' => 'admin@root.com',
            'password' => bcrypt('123456')
        ]);

        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

        $employee = factory(Employee::class)->create();

		$this->withHeaders(["Authorization" => 'Bearer '.$token])
			->json('GET', '/api/employees/'.$employee->id.'/edit')
			->assertStatus(200)
			->assertExactJson([
				'employee' => [
					'id' => $employee->id,
					'names' => $employee->names,
					'surnames' => $employee->surnames,
					'identity_number' => $employee->identity_number,
					'birthdate' => $employee->birthdate,
					'email' => $employee->email,
					'phone' => $employee->phone,
					'profile_pic' => $employee->profile_pic,
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
				'occupations' => [
					[
						'id' => $employee->occupation->id,
						'name' => $employee->occupation->name,
						'description' => $employee->occupation->description
					]
				]
		]);
    }

    /** @test */
    public function one_employee_can_be_finded()
    {
    	//$this->withoutExceptionHandling();

        $user = factory(User::class)->create([
            'email' => 'admin@root.com',
            'password' => bcrypt('123456')
        ]);

        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

      	$employee = factory(Employee::class)->create();

		$this->withHeaders(["Authorization" => 'Bearer '.$token])
			->json('GET', '/api/employees/'.$employee->id)
			->assertStatus(200)
			->assertExactJson([
				'employee' => [
					'id' => $employee->id,
					'names' => $employee->names,
					'surnames' => $employee->surnames,
					'identity_number' => $employee->identity_number,
					'birthdate' => $employee->birthdate,
					'email' => $employee->email,
					'phone' => $employee->phone,
					'profile_pic' => $employee->profile_pic,
					'occupation_id' => $employee->occupation_id,
					'created_at' => (string)$employee->created_at,
					'updated_at' => (string)$employee->updated_at,
					'deleted_at' => NULL,
					'occupation' => [
						'id' => $employee->occupation->id,
						'name' => $employee->occupation->name,
						'description' => $employee->occupation->description
					]
				]
		]);
    }

    /** @test */
    public function employees_can_be_listed()
    {
    	$this->withoutExceptionHandling();

        $user = factory(User::class)->create([
            'email' => 'admin@root.com',
            'password' => bcrypt('123456')
        ]);

        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

      	$employee = factory(Employee::class)->create();

		$this->withHeaders(["Authorization" => 'Bearer '.$token])
			->json('GET', '/api/employees/')
			->assertStatus(200)
			->assertExactJson([
				'employees' => [
					[
						'id' => $employee->id,
						'names' => $employee->names,
						'surnames' => $employee->surnames,
						'identity_number' => $employee->identity_number,
						'birthdate' => $employee->birthdate,
						'email' => $employee->email,
						'phone' => $employee->phone,
						'profile_pic' => $employee->profile_pic,
						'occupation_id' => $employee->occupation_id,
						'created_at' => (string)$employee->created_at,
						'updated_at' => (string)$employee->updated_at,
						'deleted_at' => NULL,
						'occupation' => [
							'id' => $employee->occupation->id,
							'name' => $employee->occupation->name,
							'description' => $employee->occupation->description
						]
					]
				]
		]);
    }
}
