<?php

namespace App\Mail;

use App\Atleta;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Confirmacion extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Atleta $atleta)
    {
        //
        $this->atleta = $atleta;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('inscripciones@torneoarena.cl')
                    ->subject('LO SENTIMOS')
                    ->view('mail.confirmacion')
                    ->with([
                        'atleta' => $this->atleta
                    ]);
    }
}
