<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class GoogleSheetController extends Controller {
    public function fetch($count = null) {
        $process = new Process(["php", "artisan", "google:fetch", $count]);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return nl2br($process->getOutput());
    }
}
