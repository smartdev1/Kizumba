<?php

namespace App\Mail;

use App\Models\IssuedTicket;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TicketMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $qrCodeBase64;

    public function __construct(public IssuedTicket $issuedTicket)
    {
        // Génération QR code en PNG base64 (embarqué dans l'email)
        $qrImage = QrCode::format('png')
            ->size(250)
            ->errorCorrection('H')
            ->generate($issuedTicket->uid);

        $this->qrCodeBase64 = base64_encode($qrImage);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Votre billet — {$this->issuedTicket->ticket_name} · United Kizdom World Congress",
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.ticket',
            with: [
                'issuedTicket'   => $this->issuedTicket,
                'qrCodeBase64'   => $this->qrCodeBase64,
                'festivalName'   => 'United Kizdom World Congress',
                'festivalDates'  => '19 – 23 novembre 2026',
                'festivalVenue'  => 'Hilton Paris Charles de Gaulle Airport',
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
