<?php

namespace App\Actions\Tags;

use App\Models\Tag;

class ListTags
{
    public function execute()
    {
        return Tag::select(['id', 'name', 'color'])->get();
    }
}
