<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Pedido;

class BillReceived extends Mailable
{
    use Queueable, SerializesModels;
    public $subject= 'Entrega del pedido CerveWeb S.A';
    public $pdf;
    public $pedido;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pdf,$idPedido)
    {
        $this->pdf=$pdf;
        $this->pedido=Pedido::find($idPedido);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.bill-received',compact('pedido'))->attachData($this->pdf, 'FacturaPedido.pdf');
    }
}
