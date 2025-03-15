<?php

namespace App\Actions\Tags;

class UpdateTag
{
    public function execute($request, $id)
    {
        $tag = resolve(DetailTag::class)->execute($id);

        return tap($tag)->update($request);
    }
}
