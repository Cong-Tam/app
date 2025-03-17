<?php

namespace App\Http\Controllers\Api;

use App\Actions\ListContacts\CreateListContact;
use App\Actions\ListContacts\DeleteListContact;
use App\Actions\ListContacts\DetailListContact;
use App\Actions\ListContacts\ListListConacts;
use App\Actions\ListContacts\UpdateListContact;
use App\Http\Controllers\Controller;
use App\Http\Requests\ListContact\CreateListContactRequest;
use App\Http\Requests\ListContact\UpdateListContactRequest;
use Illuminate\Http\Request;

class ListContactController extends Controller
{
    public function index() {
        $result = resolve(ListListConacts::class)->execute();

        return response()->json($result);
    }

    public function store(CreateListContactRequest $request) {
        $result = resolve(CreateListContact::class)->execute($request->validated());

        return response()->json($result);
    }

    public function detail($id) {
        $result = resolve(DetailListContact::class)->execute($id);

        return response()->json($result);
    }

    public function update(UpdateListContactRequest $request, $id) {
        $result = resolve(UpdateListContact::class)->execute($request->validated(), $id);

        return response()->json($result);
    }

    public function delete($id) {
        resolve(DeleteListContact::class)->execute($id);

        return response()->json([
            'message' => 'Delete list contact success'
        ]);
    }
}
