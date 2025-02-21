<?php
namespace App\Console\Commands;

use Google_Client;
use Google_Service_Sheets;
use Google_Service_Sheets_ValueRange;

class GoogleSheetsService
{
    protected $service;

    public function __construct()
    {
        $client = new Google_Client();
        $client->setApplicationName('Laravel Google Sheets');
        $client->setScopes(Google_Service_Sheets::SPREADSHEETS);
        $client->setAuthConfig(storage_path('app/credentials.json'));
        $client->setAccessType('offline');

        $this->service = new Google_Service_Sheets($client);
    }

    public function updateSheet($spreadsheetId, $range, $values)
    {
        $body = new Google_Service_Sheets_ValueRange([
            'values' => $values
        ]);

        $params = [
            'valueInputOption' => 'RAW'
        ];

        return $this->service->spreadsheets_values->update($spreadsheetId, $range, $body, $params);
    }

    public function getSheet($spreadsheetId, $range)
    {
        return $this->service->spreadsheets_values->get($spreadsheetId, $range);
    }
}