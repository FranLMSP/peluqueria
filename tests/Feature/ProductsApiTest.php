<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\User;
use App\Product;
use App\ProductHeader;

class ProductsTest extends TestCase
{
	use RefreshDatabase;

    /** @test */
    public function product_can_be_created()
    {
        $user = factory(User::class)->create([
            'email' => 'admin@root.com',
            'password' => bcrypt('123456')
        ]);

        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

		$this->withHeaders(["Authorization" => 'Bearer '.$token])
		->json('POST', '/api/products', [
			'name' => 'Planchado',
			'description' => 'Planchado de pelo',
			'price' => 20.5
		])->assertStatus(201);

		$this->assertDatabaseHas('product_headers', [
			'name' => 'Planchado',
			'description' => 'Planchado de pelo'
		]);

		$this->assertDatabaseHas('products', [
			'price' => 20.5
		]);
    }

    /** @test */
    public function product_price_update()
    {
        $user = factory(User::class)->create([
            'email' => 'admin@root.com',
            'password' => bcrypt('123456')
        ]);

        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

        $product = factory(Product::class)->create([
        	'price' => 10.5,
        	'product_header_id' => factory(ProductHeader::class)->create(['name'=>'Planchado', 'description'=> 'Planchado de pelo'])
        ]);


		$this->withHeaders(["Authorization" => 'Bearer '.$token])
		->json('PUT', '/api/products'.$product->id, [
			'name' => 'Planchado E',
			'description' => 'Planchado de pelo E',
			'price' => 20.5
		])->assertStatus(200);

		$editedProduct = Product::where('active', true)->first();

		$this->assertTrue((
			$editedProduct->definition()->name == 'Planchado E' && 
			$editedProduct->definition()->description == 'Planchado de pelo E' && 
			$editedProduct->price == 20.5
		));
    }
}
