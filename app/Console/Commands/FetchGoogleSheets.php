<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Console\Commands\GoogleSheetService;
use App\Models\Item;

class FetchGoogleSheets extends Command
{
    protected $signature = 'google:fetch {count?}';
    protected $description = 'Fetch data from Google Sheet';

    public function handle() {
        $service = new GoogleSheetService(config('services.google.spreadsheet_id'));
        $data = $service->getData();
        $count = $this->argument('count') ?? count($data);
    
        $bar = $this->output->createProgressBar($count);
        $bar->start();
    
        foreach (array_slice($data, 0, $count) as $row) {
            $id = $row[0] ?? null;
            $comment = $row[1] ?? null;
    
           
            if ($id && $comment) {
                Item::updateOrCreate(
                    ['id' => $id],
                    ['name' => $comment]
                );
            }
            // убрать комментарий если нужно видеть какие данные загружаются
            // $this->info("ID: {$id} | Comment: {$comment}"); 
            $bar->advance();
        }
    
        $bar->finish();
        $this->info("\nДанные успешно загружены в БД!");
    }
}
