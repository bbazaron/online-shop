<?php

namespace App\Mail;

use App\Models\User;
use Faker\Provider\Address;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class Testmail extends Mailable
{
    use Queueable, SerializesModels;
    public $username;
    public $bodyText;
    public $ctaUrl;
    public $fromName;


    /**
     * Create a new message instance.
     */
    public function __construct($username, $bodyText=null, $ctaUrl=null, $fromName=null)
    {
        $this->username     = $username;
        $this->bodyText = $bodyText ?? 'Пример содержимого письма.';
        $this->ctaUrl   = $ctaUrl ?? url('/');
        $this->fromName = $fromName ?? config('mail.from.address');
    }

    public function build()
    {
        return $this->subject('Тестовая рассылка')
            ->markdown('emails.test');
    }

//    public function build()
//    {
//        return $this->view('emails.test')
//            ->with([
//                'username'     => $this->username,
//                'bodyText' => $this->bodyText,
//                'ctaUrl'   => $this->ctaUrl,
//                'fromName' => $this->fromName,
//            ]);
//    }


    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Тема письма',
            from: config('mail.from.address')
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.test',
            with: [
                'username'     => $this->username,
                'bodyText' => $this->bodyText,
                'ctaUrl'   => $this->ctaUrl,
                'fromName' => $this->fromName,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }


}
