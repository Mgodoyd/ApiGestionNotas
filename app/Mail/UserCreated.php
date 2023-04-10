<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public function __construct(User $user)//constructor de la clase y se le pasa el usuario
    {
        $this->user = $user;
    }

    public function envelope(): Envelope //metodo para enviar el correo
    {
        return new Envelope(
            subject: 'User Created',
        );
    }

    public function content(): Content //metodo para enviar el correo
    {
        return new Content(
            text: 'emails.welcome',
        );
    }

    public function attachments(): array //metodo para enviar el correo
    {
        return [];
    }
}
