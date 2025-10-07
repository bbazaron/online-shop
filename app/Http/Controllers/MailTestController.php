<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\SendTestEmailJob;

class MailTestController extends Controller
{
    public function send(Request $request)
    {
        $email = $request->input('email', 'youremail@example.com');

        SendTestEmailJob::dispatch($email);

        return response()->json([
            'message' => 'Письмо отправлено в очередь!',
            'email' => $email,
        ]);
    }
}
