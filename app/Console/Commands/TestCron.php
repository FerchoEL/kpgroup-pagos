<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestCron extends Command
{
    protected $signature = 'test:cron';
    protected $description = 'Verifica si el cron realmente corre';

    public function handle()
    {
        \Log::info('🧪 Comando dummy test:cron ejecutado correctamente: ' . now());
        $this->info('OK!');
    }
}
