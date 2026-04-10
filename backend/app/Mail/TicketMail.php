<?php

namespace App\Mail;

use App\Models\IssuedTicket;
use App\Services\TicketImageService;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class TicketMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $qrCodeBase64;
    public ?string $ticketImagePath = null;
    public ?string $ticketImageBase64 = null;

    public function __construct(public IssuedTicket $issuedTicket)
    {
        // S'assurer que la relation ticket est chargée (nécessaire pour l'image template)
        $issuedTicket->loadMissing('ticket');

        $imageService = app(TicketImageService::class);

        // QR code enrichi : Nom + Date d'achat + UID
        $qrContent = $imageService->buildQrContent($issuedTicket);

        $qrCode = QrCode::create($qrContent)
            ->setErrorCorrectionLevel(ErrorCorrectionLevel::High)
            ->setSize(250)
            ->setMargin(10);

        $qrPng = (new PngWriter())->write($qrCode)->getString();

        $this->qrCodeBase64 = base64_encode($qrPng);

        // Génération du billet avec QR injecté dans l'image template
        try {
            $this->ticketImagePath = $imageService->compositeTicketImage($issuedTicket, $qrPng);
            // Embarquer l'image composite en base64 pour l'afficher dans le corps de l'email
            $this->ticketImageBase64 = base64_encode(file_get_contents($this->ticketImagePath));
        } catch (\Exception $e) {
            Log::warning('TicketMail: génération image billet échouée, envoi sans pièce jointe', [
                'uid'   => $issuedTicket->uid,
                'error' => $e->getMessage(),
            ]);
        }
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
                'issuedTicket'       => $this->issuedTicket,
                'qrCodeBase64'       => $this->qrCodeBase64,
                'ticketImageBase64'  => $this->ticketImageBase64,
                'festivalName'       => 'United Kizdom World Congress 2026',
                'festivalDates'      => '14 au 19 juillet 2026',
                'festivalVenue'      => 'Cotonou (Bénin)',
            ],
        );
    }

    public function attachments(): array
    {
        if (!$this->ticketImagePath || !file_exists($this->ticketImagePath)) {
            return [];
        }

        return [
            Attachment::fromPath($this->ticketImagePath)
                ->as("billet-{$this->issuedTicket->uid}.jpg")
                ->withMime('image/jpeg'),
        ];
    }
}
