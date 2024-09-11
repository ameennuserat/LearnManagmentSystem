<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
//use resources\views\send-code-activation;

class VerificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    protected $name,$code;
    public function __construct($name,$code)
    {
        $this->name = $name;
        $this->code = $code;
    }

    public function build()
    {
        return $this->markdown('send-code-activation');
    }

    /**
     * Get the message envelope.
      */
    // public function envelope(): Envelope
    // {
    //     return new Envelope(
    //         subject: 'Verification Email',
    //     );
    // }

    // /**
    //  * Get the message content definition.
    //  */
    // public function content(): Content
    // {
    //     return new Content(
    //         view: 'mail',
    //         with: [
    //             'name' => $this->name,
    //             'link' => env('APP_URL') . "?token=" .$this->token,
    //         ],
    //     );
    // }

    // /**
    //  * Get the attachments for the message.
    //  *
    //  * @return array<int, \Illuminate\Mail\Mailables\Attachment>
    //  */
    // public function attachments(): array
    // {
    //     return [];
    // }
}
