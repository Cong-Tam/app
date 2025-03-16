<?php

namespace App\Actions\Managers;

class DeleteManager
{
    public function execute($id)
    {
        $manager = resolve(DetailManager::class)->execute($id, false);

        return $manager->delete();
    }
}
