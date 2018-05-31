<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Customer;
use App\Mail;
use App\MailStatus;

class MailApiTest extends TestCase
{
	use RefreshDatabase;

    /** @test */
    public function one_mail_can_be_sent()
    {
    	$this->withoutExceptionHandling();
        $user = factory(User::class)->create([
            'email' => 'admin@root.com',
            'password' => bcrypt('123456')
        ]);

        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

        $customer = factory(Customer::class)->create();

        $mailStatus = factory(MailStatus::class)->create([
        	'name' => 'Enviado',
        	'active' => true
        ]);

        $this->withHeaders(["Authorization" => 'Bearer '.$token])
        ->json('POST', '/api/mail/', [
        	'customer_id' => $customer->id,
        	'email' => $customer->email,
        	'subject' => 'Test email',
        	'message' => '<p>This is an test message</p>', 
        ])->assertStatus(201);

        $this->assertDatabaseHas('mails', [
        	'customer_id' => $customer->id,
        	'email' => $customer->email,
        	'subject' => 'Test email',
        	'message' => '<p>This is an test message</p>'
        ]);
    }
}
