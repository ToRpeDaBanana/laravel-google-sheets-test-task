<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Console\Commands\GoogleSheetService;

class SyncGoogleSheet extends Command
{
    protected $signature = 'sync:google-sheet';
    protected $description = 'Sync allowed items with Google Sheets';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(GoogleSheetService $googleSheetService)
    {
        $this->info('Синхронизация с Google Таблицей...');
        $googleSheetService->syncData();
        $this->info('Данные успешно синхронизированы!');
    }
}

