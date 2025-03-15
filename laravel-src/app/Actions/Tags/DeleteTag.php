<?php

namespace App\Actions\Tags;

class DeleteTag
{
    public function execute($id)
    {
        $tag = resolve(DetailTag::class)->execute($id);

        return $tag->delete();
    }
}
