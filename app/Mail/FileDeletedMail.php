<?php

namespace App\Mail;

use App\Models\File;
use Illuminate\Mail\Mailable;

class FileDeletedMail extends Mailable
{
    public $file;

    public function __construct(File $file)
    {
        $this->file = $file;
    }

    public function build()
    {
        return $this->view('emails.file_deleted')->with([
            'filename' => $this->file->filename,
        ]);
    }
}
