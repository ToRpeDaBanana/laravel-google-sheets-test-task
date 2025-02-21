<?php
namespace App\Services;

use Google\Client;
use Google\Service\Sheets;
use App\Models\Item;


class GoogleSheetService
{
    protected $client;
    protected $service;
    protected $spreadsheetId;

    public function __construct()
    {
        $this->client = new Client();
        $this->client->setApplicationName('Laravel Google Sheets');
        $this->client->setScopes([Sheets::SPREADSHEETS]);
        $this->client->setAuthConfig(config('services.google.credentials_path'));
        $this->client->setAccessType('offline');

        $this->service = new Sheets($this->client);
        $this->spreadsheetId = config('services.google.spreadsheet_id');
    }

    public function syncData()
    {

        $existingComments = $this->getExistingComments();

        $this->clearSheet();

        $items = Item::allowed()->get();


        $values = [["ID", "Name", "Description", "Status", "Comment"]];

        foreach ($items as $item) {
            // Используем существующий комментарий, если он есть
            $comment = $existingComments[$item->id] ?? "";

            $values[] = [$item->id, $item->name, $item->description, $item->status, $comment];
        }

        $body = new \Google\Service\Sheets\ValueRange([
            'values' => $values
        ]);

        $params = ['valueInputOption' => 'RAW'];
        $range = 'DataSheet!A1';

        $this->service->spreadsheets_values->update($this->spreadsheetId, $range, $body, $params);
    }

    /**
     * Получает комментарии из Google Sheets и связывает их с ID записей
     */
    private function getExistingComments()
    {
        $range = "DataSheet!A2:E";
        $response = $this->service->spreadsheets_values->get($this->spreadsheetId, $range);
        $values = $response->getValues();

        $comments = [];
        if (!isset($comments)){
            foreach ($values as $row) {
                if (isset($row[0]) && isset($row[4])) {
                    $comments[$row[0]] = $row[4]; // ID => Comment
                }
            }
        }

        return $comments;
    }

    private function clearSheet()
    {
        $requestBody = new \Google\Service\Sheets\ClearValuesRequest();
        $this->service->spreadsheets_values->clear($this->spreadsheetId, 'DataSheet!A2:E', $requestBody);
    }

    public function getData() {
        $allValues = [];
        $batchSize = 500;
        $startRow = 2;
    
        while (true) {
            $endRow = $startRow + $batchSize - 1;
            $range = "DataSheet!A{$startRow}:E{$endRow}";
    
            $response = $this->service->spreadsheets_values->get($this->spreadsheetId, $range);
            $values = $response->getValues();
    
            if (empty($values)) break;
    
            $allValues = array_merge($allValues, $values);
            $startRow += $batchSize;
        }
    
        \Log::info('Всего загружено строк: ' . count($allValues));
    
        return $allValues;
    }
    
    
}

