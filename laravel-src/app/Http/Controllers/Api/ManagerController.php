<?php

namespace App\Http\Controllers\Api;

use App\Actions\Managers\CreateManager;
use App\Actions\Managers\DeleteManager;
use App\Actions\Managers\DetailManager;
use App\Actions\Managers\ListManagers;
use App\Actions\Managers\UpdateManager;
use App\Http\Controllers\Controller;
use App\Http\Requests\Manager\CreateManagerRequest;
use App\Http\Requests\Manager\UpdateManagerRequest;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    public function store(CreateManagerRequest $request) {
        $result = resolve(CreateManager::class)->execute($request->validated());

        return response()->json($result);
    }

    public function detail($id) {
        $result = resolve(DetailManager::class)->execute($id);

        return response()->json($result);
    }

    public function update(UpdateManagerRequest $request, $id) {
        $result = resolve(UpdateManager::class)->execute($request->validated(), $id);

        return response()->json($result);
    }

    public function delete($id) {
        resolve(DeleteManager::class)->execute($id);

        return response()->json([
            'message' => 'Delete tag success'
        ]);
    }
}
