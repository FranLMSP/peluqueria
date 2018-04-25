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
		])->assertStatus(200);

		$this->assertDatabaseHas('customers', [
			'names' => 'Franco',
			'surnames' => 'Colmenarez',
			'identity_number' => 25896369,
			'email' => 'a@a.com',
			'phone' => '+123456',
		]);
	}

}
