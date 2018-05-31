<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Customer;
use App\Mail as MailModel;
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

    /** @test */
    public function mails_can_be_listed()
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

        $mail = factory(MailModel::class)->create();

        $this->withHeaders(["Authorization" => 'Bearer '.$token])
        ->json('GET','/api/mail/')
        ->assertExactJson([
            'mails' => [
                [
                    'id' => $mail->id,
                    'subject' => $mail->subject,
                    'message' => $mail->message,
                    'email' => $mail->email,
                    'customer_id' => $customer->id,
                    'status_id' => $mailStatus->id,
                    'created_at' => (string)$mail->created_at,
                    'updated_at' => (string)$mail->updated_at,
                    'customer' => [
                        'id' => $customer->id,
                        'names' => $customer->names,
                        'surnames' => $customer->surnames,
                        'identity_number' => (int)$customer->identity_number,
                        'email' => $customer->email,
                        'phone' => $customer->phone,
                        'birthdate' => $customer->birthdate,
                        'created_at' => (string)$customer->created_at,
                        'deleted_at' => NULL,
                        'updated_at' => (string)$customer->updated_at
                    ],
                    'status' => [
                        'id' => $mailStatus->id,
                        'name' => $mailStatus->name,
                        'description' => $mailStatus->description,
                        'active' => $mailStatus->active,
                    ]
                ]
            ]
        ]);
    }


    /** @test */
    public function mails_create_data_can_be_listed()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create([
            'email' => 'admin@root.com',
            'password' => bcrypt('123456')
        ]);

        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

        $customer = factory(Customer::class)->create();

        $this->withHeaders(["Authorization" => 'Bearer '.$token])
        ->json('GET','/api/mail/create')
        ->assertExactJson([
            'customers' => [
                [
                    'id' => $customer->id,
                    'names' => $customer->names,
                    'surnames' => $customer->surnames,
                    'identity_number' => (int)$customer->identity_number,
                    'email' => $customer->email,
                    'phone' => $customer->phone,
                    'birthdate' => $customer->birthdate,
                    'created_at' => (string)$customer->created_at,
                    'deleted_at' => NULL,
                    'updated_at' => (string)$customer->updated_at
                ]
            ]
        ]);
    }

    /** @test */
    public function one_mail_can_be_finded()
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

        $mail = factory(MailModel::class)->create();

        $this->withHeaders(["Authorization" => 'Bearer '.$token])
        ->json('GET','/api/mail/'.$mail->id)
        ->assertExactJson([
            'mail' => [
                'id' => $mail->id,
                'subject' => $mail->subject,
                'message' => $mail->message,
                'email' => $mail->email,
                'customer_id' => $customer->id,
                'status_id' => $mailStatus->id,
                'created_at' => (string)$mail->created_at,
                'updated_at' => (string)$mail->updated_at,
                'customer' => [
                    'id' => $customer->id,
                    'names' => $customer->names,
                    'surnames' => $customer->surnames,
                    'identity_number' => (int)$customer->identity_number,
                    'email' => $customer->email,
                    'phone' => $customer->phone,
                    'birthdate' => $customer->birthdate,
                    'created_at' => (string)$customer->created_at,
                    'deleted_at' => NULL,
                    'updated_at' => (string)$customer->updated_at
                ],
                'status' => [
                    'id' => $mailStatus->id,
                    'name' => $mailStatus->name,
                    'description' => $mailStatus->description,
                    'active' => $mailStatus->active,
                ]
            ]
        ]);
    }

}
