<?php

namespace App\Services\Files;

use Illuminate\Support\Facades\Storage;

class StorageFile implements FileInterface
{
    public function __construct()
    {
        // Construct
    }

    public function url($imagePath): string
    {
        return Storage::url($imagePath);
    }
}
