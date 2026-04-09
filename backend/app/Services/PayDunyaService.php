<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PayDunyaService
{
    private string $baseUrl;
    private string $masterKey;
    private string $privateKey;
    private string $token;
    private bool $isLive;

    public function __construct()
    {
        $this->isLive     = config('paydunya.mode') === 'live';
        $this->baseUrl    = $this->isLive
            ? 'https://app.paydunya.com/api/v1'
            : 'https://app.paydunya.com/sandbox-api/v1';

        $this->masterKey  = config('paydunya.master_key');
        $this->privateKey = config('paydunya.private_key');
        $this->token      = config('paydunya.token');
    }

    /**
     * Crée une facture PayDunya et retourne l'URL de paiement.
     */
    public function createInvoice(array $params): array
    {
        // $params: tx_ref, amount, description, customer, return_url, cancel_url, callback_url
        $payload = [
            'invoice' => [
                'items'        => [],           // associative → {} en JSON (rempli ci-dessous)
                'taxes'        => new \stdClass(),  // requis par PayDunya (vide = {})
                'total_amount' => $params['amount'],
                'description'  => $params['description'] ?? 'Festival Kizomba — Billet',
            ],
            'store' => [
                'name'           => config('paydunya.store_name', 'United Kizdom World Congress'),
                'tagline'        => config('paydunya.store_tagline', 'Festival de danse kizomba'),
                'postal_address' => config('paydunya.store_address', 'Cotonou, Bénin'),
                'website_url'    => config('paydunya.store_website', 'http://localhost:3000'),  // requis
            ],
            'actions' => [
                'cancel_url'   => $params['cancel_url'] ?? config('paydunya.cancel_url'),
                'return_url'   => $params['return_url'] ?? config('paydunya.return_url'),
                'callback_url' => $params['callback_url'] ?? config('paydunya.callback_url'),
            ],
            'custom_data' => [
                'tx_ref'  => $params['tx_ref'],
            ],
        ];

        // Ajout des items du panier
        if (!empty($params['items'])) {
            foreach ($params['items'] as $item) {
                $payload['invoice']['items'][$item['slug']] = [
                    'name'        => $item['name'],
                    'quantity'    => $item['quantity'],
                    'unit_price'  => $item['unit_price'],
                    'total_price' => $item['unit_price'] * $item['quantity'],
                    'description' => $item['description'] ?? '',
                ];
            }
        }

        // Ajout du client
        if (!empty($params['customer'])) {
            $payload['customer'] = [
                'name'  => $params['customer']['name'],
                'email' => $params['customer']['email'],
                'phone' => $params['customer']['phone'] ?? '',
            ];
        }

        Log::debug('PayDunya createInvoice → payload', ['payload' => $payload]);

        $response = Http::withHeaders($this->headers())
            ->post("{$this->baseUrl}/checkout-invoice/create", $payload);

        Log::debug('PayDunya createInvoice ← response', [
            'status' => $response->status(),
            'body'   => $response->json(),
        ]);

        if ($response->failed()) {
            Log::error('PayDunya createInvoice failed', [
                'status'   => $response->status(),
                'body'     => $response->body(),
                'tx_ref'   => $params['tx_ref'],
            ]);
            throw new \RuntimeException('Erreur PayDunya : ' . $response->body());
        }

        $data = $response->json();

        if (($data['response_code'] ?? '') !== '00') {
            throw new \RuntimeException('PayDunya refus : ' . ($data['response_text'] ?? 'Erreur inconnue'));
        }

        // PayDunya retourne l'URL réelle dans response_text (plus fiable que la construire manuellement)
        $paymentUrl = filter_var($data['response_text'] ?? '', FILTER_VALIDATE_URL)
            ? $data['response_text']
            : ($this->isLive
                ? "https://app.paydunya.com/checkout/v3/pay/{$data['token']}"
                : "https://app.paydunya.com/sandbox/checkout/v3/pay/{$data['token']}");

        return [
            'token'       => $data['token'],
            'payment_url' => $paymentUrl,
        ];
    }

    /**
     * Vérifie le statut d'une facture via son token.
     * Retourne true uniquement si le paiement est confirmed côté PayDunya.
     */
    public function verifyInvoice(string $token): array
    {
        $response = Http::withHeaders($this->headers())
            ->get("{$this->baseUrl}/checkout-invoice/confirm/{$token}");

        if ($response->failed()) {
            Log::error('PayDunya verifyInvoice failed', [
                'token'  => $token,
                'status' => $response->status(),
            ]);
            throw new \RuntimeException('Erreur vérification PayDunya');
        }

        $data = $response->json();

        return [
            'status'    => $data['status'] ?? 'unknown',
            'completed' => ($data['status'] ?? '') === 'completed',
            'raw'       => $data,
        ];
    }

    private function headers(): array
    {
        return [
            'PAYDUNYA-MASTER-KEY'  => $this->masterKey,
            'PAYDUNYA-PRIVATE-KEY' => $this->privateKey,
            'PAYDUNYA-TOKEN'       => $this->token,
            'Content-Type'         => 'application/json',
        ];
    }
}
