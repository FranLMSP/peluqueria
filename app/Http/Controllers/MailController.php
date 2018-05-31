<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Mail as MailModel;
use App\Customer;
use App\MailStatus;

class MailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'email' => 'nullable|email',
            'subject' => 'required|max:255',
            'message' => 'required'
        ], [
            'customer_id.exists' => 'El cliente seleccionado no existe',
            'email.email' => 'El email especificado no es válido',
            'subject.required' => 'Debe especificar el asunto',
            'message' => 'El mensaje no puede estar vacío'
        ]);

        $email = '';

        if(!$request->customer_id && !$request->email) {
            return response()->json([
                'error' => 'Debe especificar un cliente o un email'
            ], 422);
        }

        if($request->customer_id) {
            $customer = Customer::find($request->customer_id);
            $email = $customer->email;
        }

        if($request->email) {
            $email = $request->email;
        }

        $subject = $request->subject;

        Mail::send('mailtemplate', [
            'content' => $request->message,
            'subject' => $request->subject,
        ], function($message) use ($email, $subject) {
            $message->from(
                env("MAIL_USERNAME", "peluqueria@gmail.com"),
                env("APP_NAME", "Peluquería")
            );

            $message->to($email);

            $message->subject($subject);
        });

        $mail = new MailModel([
            'email' => $email,
            'subject' => $request->subject,
            'message' => $request->message,
            'customer_id' => $request->customer_id,
            'status_id' => MailStatus::where('name', 'Enviado')->get()->first()->id
        ]);

        $mail->save();

        return response()->json([
            'mail' => $mail
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Mail  $mail
     * @return \Illuminate\Http\Response
     */
    public function show(Mail $mail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Mail  $mail
     * @return \Illuminate\Http\Response
     */
    public function edit(Mail $mail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Mail  $mail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mail $mail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Mail  $mail
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mail $mail)
    {
        //
    }
}
