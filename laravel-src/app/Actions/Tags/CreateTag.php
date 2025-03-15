<?php

namespace App\Actions\Tags;

use App\Models\Tag;

class CreateTag
{
    public function execute($request)
    {
        return Tag::create($request);
    }
}
