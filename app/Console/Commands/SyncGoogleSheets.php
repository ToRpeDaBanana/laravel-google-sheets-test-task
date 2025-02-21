<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Item;

class SyncGoogleSheets extends Command
{
    protected $signature = 'sync:google-sheets';
    protected $description = 'Sync data with Google Sheets';

    public function handle()
    {
        $service = new GoogleSheetsService();
        $spreadsheetId = '1v7z-sal_g2M3nf0mUvKbj7TwiR2Coe4OG79FXY0kqT4';
        $range = 'Sheet1!A1:D';

        $items = Item::where('status', 'Allowed')->get();
        $values = $items->map(function ($item) {
            return [$item->id, $item->name, $item->status, $item->created_at];
        })->toArray();

        $service->updateSheet($spreadsheetId, $range, $values);

        $this->info('Data synced successfully.');
    }
}
