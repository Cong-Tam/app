<?php

namespace App\Actions\Tags;

use App\Models\Tag;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DetailTag
{
    public function execute($id)
    {
        $tag = Tag::find($id);

        if (!$tag) {
            throw new NotFoundHttpException('Tag not found');
        }

        return $tag;
    }
}
