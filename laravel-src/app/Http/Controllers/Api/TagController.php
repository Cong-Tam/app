<?php

namespace App\Http\Controllers\Api;

use App\Actions\Tags\CreateTag;
use App\Actions\Tags\DeleteTag;
use App\Actions\Tags\DetailTag;
use App\Actions\Tags\ListTags;
use App\Actions\Tags\UpdateTag;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tag\CreateTagRequest;
use App\Http\Requests\Tag\UpdateTagRequest;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index() {
        $result = resolve(ListTags::class)->execute();

        return response()->json($result);
    }

    public function store(CreateTagRequest $request) {
        $result = resolve(CreateTag::class)->execute($request->validated());

        return response()->json($result);
    }

    public function detail($id) {
        $result = resolve(DetailTag::class)->execute($id);

        return response()->json($result);
    }

    public function update(UpdateTagRequest $request, $id) {
        $result = resolve(UpdateTag::class)->execute($request->validated(), $id);

        return response()->json($result);
    }

    public function delete($id) {
        $result = resolve(DeleteTag::class)->execute($id);

        return response()->json([
            'message' => 'Delete tag success'
        ]);
    }
}
