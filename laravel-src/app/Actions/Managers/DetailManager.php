<?php

namespace App\Actions\Managers;

use App\Models\User;
use App\Services\FileService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DetailManager
{
    public function execute($id, $isShow = true)
    {
        $manager = User::find($id);

        if (!$manager) {
            throw new NotFoundHttpException('Manager not found');
        }

        if ($isShow && $manager->avatar) {
            $manager->avatar = FileService::url($manager->avatar);
        }

        return $manager;
    }
}
