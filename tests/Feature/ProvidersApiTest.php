<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Provider;
use App\User;

class ProvidersApiTest extends TestCase
{
	use RefreshDatabase;

	/** @test */
	public function provider_can_be_created() {

        $user = factory(User::class)->create([
            'email' => 'admin@root.com',
            'password' => bcrypt('123456')
        ]);

        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

		$this->withHeaders(["Authorization" => 'Bearer '.$token])
		->json('POST', '/api/providers', [
			'name' => 'Franco',
			'description' => 'Colmenarez'
		])->assertStatus(201);

		$this->assertDatabaseHas('providers', [
			'name' => 'Franco',
			'description' => 'Colmenarez'
		]);
	}

	/** @test */
	public function provider_can_be_edited() {

        $user = factory(User::class)->create([
            'email' => 'admin@root.com',
            'password' => bcrypt('123456')
        ]);

        $provider = factory(Provider::class)->create();

        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

		$this->withHeaders(["Authorization" => 'Bearer '.$token])
		->json('PUT', '/api/providers/'.$provider->id, [
			'name' => 'Franco',
			'description' => 'Colmenarez'
		])->assertStatus(200);

		$this->assertDatabaseHas('providers', [
			'id' => $provider->id,
			'name' => 'Franco',
			'description' => 'Colmenarez'
		]);
	}

	/** @test */
	public function providers_can_be_listed() {

        $user = factory(User::class)->create([
            'email' => 'admin@root.com',
            'password' => bcrypt('123456')
        ]);

        $provider = factory(Provider::class)->create();

        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

		$this->withHeaders(["Authorization" => 'Bearer '.$token])
			->json('GET', '/api/providers/')
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
				]
			]);
	}

	/** @test */
	public function one_provider_can_be_finded()
	{
        $user = factory(User::class)->create([
            'email' => 'admin@root.com',
            'password' => bcrypt('123456')
        ]);

        $provider = factory(Provider::class)->create();

        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

		$this->withHeaders(["Authorization" => 'Bearer '.$token])
			->json('GET', '/api/providers/'.$provider->id)
			->assertStatus(200)
			->assertExactJson([
				'provider' => [
					'id' => $provider->id,
					'name' => $provider->name,
					'description' => $provider->description,
					'created_at' => (string)$provider->created_at,
					'deleted_at' => NULL,
					'updated_at' => (string)$provider->updated_at
				]
			]);
	}

	/** @test */
	public function provider_edit_data_can_be_finded()
	{
        $user = factory(User::class)->create([
            'email' => 'admin@root.com',
            'password' => bcrypt('123456')
        ]);

        $provider = factory(Provider::class)->create();

        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

		$this->withHeaders(["Authorization" => 'Bearer '.$token])
			->json('GET', '/api/providers/'.$provider->id.'/edit')
			->assertStatus(200)
			->assertExactJson([
				'provider' => [
					'id' => $provider->id,
					'name' => $provider->name,
					'description' => $provider->description,
					'created_at' => (string)$provider->created_at,
					'deleted_at' => NULL,
					'updated_at' => (string)$provider->updated_at
				]
			]);
	}

}
