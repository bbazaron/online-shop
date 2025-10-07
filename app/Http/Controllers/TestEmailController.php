<?php

namespace App\Http\Controllers;

use App\Mail\Testmail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class TestEmailController
{
    public function send()
    {
        Mail::to('bbazaron0@gmail.com')->send(new TestMail());
        echo 'Email sent!';
    }

    public function receive()
    {


    }


}
