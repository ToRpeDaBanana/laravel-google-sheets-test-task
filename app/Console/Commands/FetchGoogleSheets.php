<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FetchGoogleSheets extends Command
{
    protected $signature = 'fetch:google-sheets {count?}';
    protected $description = 'Fetch data from Google Sheets';

    public function handle()
    {
        $service = new GoogleSheetsService();
        $spreadsheetId = '1v7z-sal_g2M3nf0mUvKbj7TwiR2Coe4OG79FXY0kqT4';
        $range = 'Sheet1!A1:D';

        $data = $service->getSheet($spreadsheetId, $range)->getValues();
        $count = $this->argument('count') ?? count($data);

        $bar = $this->output->createProgressBar($count);

        foreach (array_slice($data, 0, $count) as $row) {
            $this->line("ID: {$row[0]}, Comment: {$row[3]}");
            $bar->advance();
        }

        $bar->finish();
    }
}
