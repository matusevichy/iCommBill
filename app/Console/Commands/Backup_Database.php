<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;

class Backup_Database extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for backup database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        //ToDo check database backup
        $filename = "backup-" . Carbon::now()->format('Y-m-d') . ".gz";

        $command = "mysqldump --user=" . env('DB_USERNAME') . " --password=" . env('DB_PASSWORD') . " --host=" . env('DB_HOST') . " " . env('DB_DATABASE') . "  | gzip > " . storage_path() . "/app/backup/" . $filename;

        $returnVar = NULL;
        $output = NULL;

        exec($command, $output, $returnVar);
    }
}