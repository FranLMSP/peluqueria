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
			'birthday' => '12/17/1997',
			'occupation_id' => $occupation->id
		])->assertStatus(201);

		$this->assertDatabaseHas('employees', [
			'names' => 'Franco',
			'surnames' => 'Colmenarez',
			'identity_number' => 25896369,
			'email' => 'a@a.com',
			'phone' => '+123456',
			'occupation_id' => $occupation->id
		]);

        $this->assertTrue(true);
    }
}
