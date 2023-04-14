<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserMail extends Mailable
{
    use Queueable, SerializesModels;
    public $model;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($model)
    {
        $this->model = $model;
    }
    /**
     * Create a new message instance.
     *
     * @return $this
     */

    public function build()
    {
        return $this
        ->subject('Un changement viens d\'être éffectuer')
        ->view('email.app')
        ->with([
            'title' =>'Mdification',
            'model' => $this->model,
        ]);
    }
}
