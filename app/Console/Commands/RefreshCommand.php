<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Database\Seeders\CatalogSeeder;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

#[Signature('app:refresh')]
#[Description('Refresh products from DB')]
class RefreshCommand extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        if (app()->isProduction()) {
            $this->error('This command cannot be run in production!');

            return self::FAILURE;
        }

        if (! $this->confirm('Are you sure you want to wipe the database and delete all images?')) {
            $this->info('Operation cancelled.');

            return self::SUCCESS;
        }
        Cache::flush();

        Storage::disk('public')->deleteDirectory('images');

        $this->call('migrate:fresh', [
            '--seed' => true,
        ]);

        $this->call('db:seed', [
            '--class' => CatalogSeeder::class,
        ]);

        return self::SUCCESS;
    }
}
