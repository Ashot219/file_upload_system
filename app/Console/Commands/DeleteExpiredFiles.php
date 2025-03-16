<?php

namespace App\Console\Commands;

use App\Models\File;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class DeleteExpiredFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-expired-files';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete files that are older than 24 hours';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $files = File::where('uploaded_at', '<', now()->subDay())->get();

        foreach ($files as $file) {
            Storage::delete($file->file_path);
            $file->delete();

            dispatch(new \App\Jobs\FileDeleted($file));
        }

        $this->info('Expired files deleted successfully');
    }
}
