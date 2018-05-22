<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Company;
use App\Region;
use App\Commune;

class CompanyApiTest extends TestCase
{
	use RefreshDatabase;

    /** @test */
    public function company_can_be_created()
    {
    	$this->withoutExceptionHandling();

        $user = factory(User::class)->create([
            'email' => 'admin@root.com',
            'password' => bcrypt('123456')
        ]);

        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

        $commune = factory(Commune::class)->create([
        	'region_id' => factory(Region::class)->create()->id
        ]);

		$this->withHeaders(["Authorization" => 'Bearer '.$token])
		->json('POST', '/api/companies', [
			'name' => 'Franco',
			'address' => 'Colmenarez',
			'commune_id' => $commune->id,
			'phone' => '+123456',
			'secondary_phone' => '+123456',
			'email' => 'a@a.com',
			'website' => 'a.com',
			'shortname' => 'portal',
			'color' => '#FFFFFF',
			'boxes' => 20
		])->assertStatus(201);

		$this->assertDatabaseHas('companies', [
			'name' => 'Franco',
			'address' => 'Colmenarez',
			'commune_id' => $commune->id,
			'phone' => '+123456',
			'secondary_phone' => '+123456',
			'email' => 'a@a.com',
			'website' => 'a.com',
			'shortname' => 'portal',
			'color' => '#FFFFFF',
			'image' => NULL,
			'boxes' => 20
		]);
    }
}
