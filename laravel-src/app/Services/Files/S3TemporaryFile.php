<?php

namespace App\Services\Files;

use Illuminate\Support\Facades\Storage;

class S3TemporaryFile implements FileInterface
{
    public function __construct()
    {
        // Construct
    }

    public function url($imagePath): string
    {
        return Storage::temporaryUrl($imagePath, now()->addHour());
    }
}
