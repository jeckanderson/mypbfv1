<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Backup\Tasks\Backup\BackupJobFactory;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:akses_backup'])->only('createBackup');
    }

    public function createBackup()
    {
        // Membuat backup
        $backupJob = BackupJobFactory::createFromArray(config('backup'));
        $backupJob->run();

        // Ambil path backup terbaru
        $path = Storage::disk(config('backup.database')[0])->files(config('backup.data'))[0];

        // Download file
        return Storage::disk(config('backup.database')[0])->download($path);
    }
}