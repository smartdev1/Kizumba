<?php

namespace App\Console\Commands;

use App\Models\Ticket;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

#[Signature('tickets:sync {--force : Forcer la mise à jour même si le ticket existe déjà}')]
#[Description('Synchronise les tickets depuis database/data/tickets.json vers la base de données')]
class SyncTickets extends Command
{
    public function handle(): int
    {
        $path = database_path('data/tickets.json');

        if (!File::exists($path)) {
            $this->error("Fichier introuvable : {$path}");
            return self::FAILURE;
        }

        $json    = json_decode(File::get($path), true);
        $tickets = $json['tickets'] ?? [];

        if (empty($tickets)) {
            $this->warn('Aucun ticket trouvé dans le fichier JSON.');
            return self::SUCCESS;
        }

        $this->info('Synchronisation de ' . count($tickets) . ' ticket(s)...');
        $this->newLine();

        $created = 0;
        $updated = 0;

        foreach ($tickets as $data) {
            $existing = Ticket::where('slug', $data['slug'])->first();

            if ($existing) {
                if ($this->option('force')) {
                    $existing->update([
                        'name'        => $data['name'],
                        'description' => $data['description'] ?? null,
                        'category'    => $data['category'],
                        'price'       => $data['price'],
                        'currency'    => $data['currency'] ?? 'FCFA',
                        'includes'    => $data['includes'] ?? [],
                        'stock'       => $data['stock'],
                        'is_active'   => true,
                    ]);
                    $this->line("  <fg=yellow>MODIFIÉ</> — {$data['name']} ({$data['slug']})");
                    $updated++;
                } else {
                    $this->line("  <fg=gray>IGNORÉ</> — {$data['name']} existe déjà (utilisez --force pour écraser)");
                }
                continue;
            }

            Ticket::create([
                'slug'        => $data['slug'],
                'name'        => $data['name'],
                'description' => $data['description'] ?? null,
                'category'    => $data['category'],
                'price'       => $data['price'],
                'currency'    => $data['currency'] ?? 'FCFA',
                'includes'    => $data['includes'] ?? [],
                'stock'       => $data['stock'],
                'sold'        => 0,
                'is_active'   => true,
            ]);

            $this->line("  <fg=green>CRÉÉ</> — {$data['name']} ({$data['slug']}) · {$data['price']} {$data['currency']}");
            $created++;
        }

        $this->newLine();
        $this->info("Terminé : {$created} créé(s), {$updated} mis à jour.");

        return self::SUCCESS;
    }
}
