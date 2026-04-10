<?php

namespace App\Services;

use App\Models\IssuedTicket;

class TicketImageService
{
    /**
     * Contenu encodé dans le QR code : Nom + Date d'achat + UID.
     */
    public function buildQrContent(IssuedTicket $issuedTicket): string
    {
        return implode("\n", [
            'UKWC 2026',
            'Titulaire : ' . $issuedTicket->holder_name,
            "Date d'achat : " . $issuedTicket->created_at->format('d/m/Y'),
            'Réf : ' . $issuedTicket->uid,
        ]);
    }

    /**
     * Injecte le QR code (PNG binaire) dans l'image template du ticket.
     * Retourne le chemin absolu de l'image générée.
     *
     * Ajuste $qrCenterXRatio / $qrCenterYRatio / $qrSizeRatio
     * pour repositionner le QR dans la zone blanche du template.
     */
    public function compositeTicketImage(IssuedTicket $issuedTicket, string $qrPng): string
    {
        $ticket = $issuedTicket->ticket;

        if (!$ticket || !$ticket->image_path) {
            throw new \RuntimeException('Aucune image template définie pour ce billet.');
        }

        $templatePath = storage_path('app/public/' . $ticket->image_path);

        if (!file_exists($templatePath)) {
            throw new \RuntimeException("Template introuvable : {$templatePath}");
        }

        // --- Chargement du template ---
        $ext      = strtolower(pathinfo($templatePath, PATHINFO_EXTENSION));
        $template = match ($ext) {
            'jpg', 'jpeg' => imagecreatefromjpeg($templatePath),
            'png'         => imagecreatefrompng($templatePath),
            'webp'        => imagecreatefromwebp($templatePath),
            default       => throw new \RuntimeException("Format non supporté : {$ext}"),
        };

        $tW = imagesx($template);
        $tH = imagesy($template);

        // --- Chargement du QR code ---
        $qrResource = imagecreatefromstring($qrPng);
        $qrW        = imagesx($qrResource);
        $qrH        = imagesy($qrResource);

        // --- Paramètres de positionnement (à ajuster selon le template) ---
        // Centre de la zone blanche en pourcentage de l'image
        $qrCenterXRatio = 0.875; // 87.5% depuis la gauche
        $qrCenterYRatio = 0.60;  // 60% depuis le haut
        $qrSizeRatio    = 0.185; // QR = 18.5% de la largeur du template

        $qrTargetSize = (int) ($tW * $qrSizeRatio);

        // --- Redimensionnement du QR ---
        $qrScaled = imagecreatetruecolor($qrTargetSize, $qrTargetSize);
        imagecopyresampled($qrScaled, $qrResource, 0, 0, 0, 0, $qrTargetSize, $qrTargetSize, $qrW, $qrH);
        imagedestroy($qrResource);

        // --- Fond blanc avec marges autour du QR ---
        $padding = (int) ($qrTargetSize * 0.06);
        $boxSize = $qrTargetSize + $padding * 2;
        $box     = imagecreatetruecolor($boxSize, $boxSize);
        $white   = imagecolorallocate($box, 255, 255, 255);
        imagefill($box, 0, 0, $white);
        imagecopy($box, $qrScaled, $padding, $padding, 0, 0, $qrTargetSize, $qrTargetSize);
        imagedestroy($qrScaled);

        // --- Placement centré dans la zone blanche ---
        $destX = (int) ($tW * $qrCenterXRatio - $boxSize / 2);
        $destY = (int) ($tH * $qrCenterYRatio - $boxSize / 2);

        imagecopy($template, $box, $destX, $destY, 0, 0, $boxSize, $boxSize);
        imagedestroy($box);

        // --- Sauvegarde ---
        $outputDir = storage_path('app/generated-tickets');
        if (!is_dir($outputDir)) {
            mkdir($outputDir, 0755, true);
        }

        $outputPath = "{$outputDir}/{$issuedTicket->uid}.jpg";
        imagejpeg($template, $outputPath, 92);
        imagedestroy($template);

        return $outputPath;
    }
}
