<?php

namespace App\Services\Files;

interface FileInterface
{
    public function __construct();

    public function url($imagePath);
}
