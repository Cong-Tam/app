<?php

namespace App\Actions\Managers;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Services\FileService;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;

class CreateManager
{
    public function execute($request)
    {
        DB::beginTransaction();
        try {
            $manager = User::create([
                'first_name' => $request['first_name'],
                'last_name' => $request['last_name'],
                'email' => $request['email'],
                'password' => $request['password'],
            ]);

            $avatarInfo = $this->handleAvatar($manager->id, $request['avatar']);

            $manager = tap($manager)->update([
                'avatar' => $avatarInfo['file_path'],
            ]);
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

    private function handleAvatar($managerId, $avatar) {
        $prefix = 'Manager/' . $managerId;

        return FileService::upload($prefix, $avatar);
    }
}
