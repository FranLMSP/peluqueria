<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use Illuminate\Support\Facades\DB;

class AuthApiTest extends TestCase
{
	use RefreshDatabase;

    /** @test */
    public function a_user_can_login_with_valid_credentials()
    {
        factory(User::class)->create([
            'email' => 'admin@root.com',
            'password' => bcrypt('123456')
        ]);

        $this->json('POST', '/api/auth/login', [
        	'email' => 'admin@root.com',
        	'password' => '123456'
        ])->assertStatus(200)
        ->assertJson([
        	'access_token' => true,
        	'token_type' => true,
        	'user' => true,
        	'expires_in' => true
        ]);
    }

    /** @test */
    public function a_user_can_not_login_with_invalid_credentials()
    {
        factory(User::class)->create([
            'email' => 'admin@root.com',
            'password' => bcrypt('123456')
        ]);

        $this->post('/api/auth/login', [
            'email' => 'foo',
            'password' => 'bar'
        ])->assertStatus(401);
    }

    /** @test */
    public function a_user_can_logout()
    {
        factory(User::class)->create([
            'email' => 'admin@root.com',
            'password' => bcrypt('123456')
        ]);

        $this->post('/api/auth/login', [
        	'email' => 'admin@root.com',
        	'password' => '123456'
        ]);
        $this->post('/api/auth/logout')->assertStatus(200);
        $this->get('/api/customers')->assertStatus(401);
    }
}
