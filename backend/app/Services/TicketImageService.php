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

        // --- Paramètres de positionnement ---
        // Zone blanche ≈ x:77–98%, y:24–86% de l'image (calculé sur 1890×591px)
        $qrCenterXRatio = 0.840; // centre horizontal de la zone blanche
        $qrCenterYRatio = 0.59;  // centre vertical de la zone blanche
        // QR = 14% de la largeur → ~265px sur 1890px
        // Zone blanche ≈ 370px de haut → box+padding ≈ 297px → ~36px de marge de chaque côté
        $qrSizeRatio    = 0.16;

        $qrTargetSize = (int) ($tW * $qrSizeRatio);

        // --- Redimensionnement du QR ---
        $qrScaled = imagecreatetruecolor($qrTargetSize, $qrTargetSize);
        imagecopyresampled($qrScaled, $qrResource, 0, 0, 0, 0, $qrTargetSize, $qrTargetSize, $qrW, $qrH);
        imagedestroy($qrResource);

        // --- Fond blanc avec marges autour du QR ---
        $padding = 12; // px fixes — indépendant de la taille du QR
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
