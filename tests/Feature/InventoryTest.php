<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\TransactionType;
use App\Transaction;
use App\Inventory;
use App\Product;
use App\Provider;
use App\Customer;

use App\User;

class InventoryTest extends TestCase
{
	use RefreshDatabase;

    /** @test */
    public function transactions_can_be_registered()
    {
    	$type = factory(TransactionType::class)->create([
    		'name' => 'Recepción',
    		'description' => 'Entrada de productos',
    		'io' => 'I'
    	]);

    	$product = factory(Product::class)->create([
    		'type' => 'P'
    	]);

		$user = factory(User::class)->create([
            'email' => 'admin@root.com',
            'password' => bcrypt('123456')
        ]);

        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

		$this->withHeaders(["Authorization" => 'Bearer '.$token])
			->json('POST', '/api/transaction', [
				'customer' => NULL,
				'provider' => $provider->id,
				'type' => $type->id,
				'products' => [
					[
						'id' => $product->id,
						'qty' => 5
					]
				],
				'description' => 'Test transaction',
			])->assertStatus(201);

    }
}
