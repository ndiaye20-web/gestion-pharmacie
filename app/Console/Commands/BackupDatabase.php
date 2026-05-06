<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup the database to storage/backups';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filename = 'backup_' . now()->format('Y_m_d_H_i_s') . '.sql';
        $path = storage_path('app/backups/' . $filename);

        // Assurer que le dossier existe
        if (!file_exists(dirname($path))) {
            mkdir(dirname($path), 0755, true);
        }

        // Utiliser mysqldump pour le backup
        $command = sprintf(
            'mysqldump --user=%s --password=%s --host=%s %s > %s',
            config('database.connections.mysql.username'),
            config('database.connections.mysql.password'),
            config('database.connections.mysql.host'),
            config('database.connections.mysql.database'),
            $path
        );

        exec($command, $output, $returnVar);

        if ($returnVar === 0) {
            $this->info('Database backup created successfully: ' . $filename);
        } else {
            $this->error('Failed to create database backup');
        }
    }
}
