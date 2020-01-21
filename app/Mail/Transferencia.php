<?php

namespace App\Mail;

use App\Atleta;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Transferencia extends Mailable
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
        return $this->from('contacto@torneoarena.cl')
                    ->subject('YA FALTA POCO PARA COMPLETAR TU REGISTRO EN ARENA 2020')
                    ->view('mail.transferencia')
                    ->with([
                        'atleta' => $this->atleta
                    ]);
    }
}
