<?php

namespace App\Jobs;

use App\Models\File;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class FileDeleted implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $file;

    public function __construct(File $file)
    {
        $this->file = $file;
    }

    public function handle()
    {
        $email = env('MAIL_FROM_ADDRESS');
        Mail::to($email)->send(new \App\Mail\FileDeletedMail($this->file));
    }
}
