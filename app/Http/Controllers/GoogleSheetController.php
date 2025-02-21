<?php

namespace App\Http\Controllers;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class GoogleSheetController extends Controller
{
    public function fetch($count = null)
{

    $projectRoot = base_path();
    $command = 'php ' . $projectRoot . '/artisan google:fetch';
    
    if ($count) {
        $command .= ' ' . $count;
    }

    $output = shell_exec($command);


    if (empty($output)) {
        \Log::error('Команда не вернула вывод или произошла ошибка');
        return "Ошибка при выполнении команды.";
    }

    return nl2br($output);
}

}
