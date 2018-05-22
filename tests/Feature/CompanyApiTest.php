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
    	//$this->withoutExceptionHandling();

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

    /** @test */
    public function companies_can_be_listed()
    {
    	//$this->withoutExceptionHandling();

        $user = factory(User::class)->create([
            'email' => 'admin@root.com',
            'password' => bcrypt('123456')
        ]);

        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);


        $region = factory(Region::class)->create();

        $commune = factory(Commune::class)->create([
        	'region_id' => $region->id
        ]);

        $company = factory(Company::class)->create([
        	'commune_id' => $commune->id
        ]);

		$this->withHeaders(["Authorization" => 'Bearer '.$token])
			->json('GET', '/api/companies')
			->assertStatus(200)
			->assertExactJson([
				'companies' => [
					[
						'id' => $company->id,
						'name' => $company->name,
						'address' => $company->address,
						'phone' => $company->phone,
						'secondary_phone' => $company->secondary_phone,
						'email' => $company->email,
						'website' => $company->website,
						'shortname' => $company->shortname,
						'color' => $company->color,
						'image' => $company->image,
						'boxes' => $company->boxes,
						'main' => false,
						'commune_id' => $company->commune_id,
						'created_at' => (string)$company->created_at,
						'updated_at' => (string)$company->updated_at,
						'deleted_at' => NULL,
						'commune' => [
							'id' => $company->commune->id, 
							'name' => $company->commune->name,
							'region_id' => $company->commune->region_id,
							'region' => [
								'id' => $company->commune->region->id,
								'name' => $company->commune->region->name
							]
						]
					]
				]
			]);
    }
}
