<?php

namespace App\Mail;

use App\Atleta;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Transbank extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Atleta $atleta, String $categoria, String $valor_pagado)
    {
        //
        $this->atleta = $atleta;
        $this->categoria = $categoria;
        $this->valor_pagado = $valor_pagado;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('pagos@torneoarena.cl')
                    ->subject('PAGO DESDE WEBPAY')
                    ->view('mail.transbank')
                    ->with([
                        'atleta' => $this->atleta,
                        'categoria' => $this->categoria,
                        'valor_pagado' => $this->valor_pagado
                    ]);
    }
}
