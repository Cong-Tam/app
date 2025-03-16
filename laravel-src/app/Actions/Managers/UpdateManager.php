<?php

namespace App\Actions\Managers;

use App\Services\FileService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateManager
{
    public function execute($request, $id)
    {
        DB::beginTransaction();

        try {
            $manager = resolve(DetailManager::class)->execute($id, false);

            $dataUpdate = [
                'first_name' => $request['first_name'],
                'last_name' => $request['last_name'],
                'email' => $request['email'],
            ];

            if (isset($request['avatar'])) {
                $avatarInfo = $this->handleAvatar($manager, $request['avatar']);
                $dataUpdate['avatar'] = $avatarInfo['file_path'];
            }

            if (isset($request['password'])) {
                $dataUpdate['password'] = $request['password'];
            }

            $manager = tap($manager)->update($dataUpdate);
            DB::commit();

            return $manager;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            throw new HttpResponseException(response()->json([
                'error' => 'Error creating user!',
            ], 500));
        }
    }

    private function handleAvatar($manager, $avatar) {
        if ($manager->avatar) {
            FileService::delete($manager->avatar); 
        }

        $prefix = 'Manager/' . $manager->id;

        return FileService::upload($prefix, $avatar);
    }
}
