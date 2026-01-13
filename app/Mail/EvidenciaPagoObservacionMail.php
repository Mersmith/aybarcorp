<?php

namespace App\Mail;

use App\Models\EvidenciaPago;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EvidenciaPagoObservacionMail extends Mailable
{
    use Queueable, SerializesModels;

    public EvidenciaPago $evidencia;
    public string $email;
    public string $url;

    public function __construct($emailDestino, EvidenciaPago $evidencia)
    {
        $this->email = $emailDestino;
        $this->evidencia = $evidencia;
        $this->url = route('admin.ticket.vista.editar', $evidencia->id);
    }

    public function build()
    {
        return $this
            ->subject('Evidencia' . $this->evidencia->id)
            ->view('emails.evidencia-pago-observacion');
    }
}
