<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MessageReceived extends Mailable
{
    
    
    use Queueable, SerializesModels;
    public $subject= 'Abastecimiento CerveWeb S.A';
    public $pdf;
    public $proveedor;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pdf,$proveedor)
    {
        $this->pdf=$pdf;
        $this->proveedor=$proveedor;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.message-received',compact('proveedor'))->attachData($this->pdf, 'OrdenCompra.pdf');;
    }
}
