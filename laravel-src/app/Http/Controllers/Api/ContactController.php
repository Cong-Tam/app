<?php

namespace App\Http\Controllers\Api;

use App\Actions\Contacts\CreateContact;
use App\Actions\Contacts\DeleteContacts;
use App\Actions\Contacts\DetailContact;
use App\Actions\Contacts\ListContacts;
use App\Actions\Contacts\UpdateContacts;
use App\Http\Controllers\Controller;
use App\Http\Requests\Contact\CreateContactRequest;
use App\Http\Requests\Contact\DeleteContactsRequest;
use App\Http\Requests\Contact\ListContactsRequest;
use App\Http\Requests\Contact\UpdateContactsRequest;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(ListContactsRequest $request) {
        $result = resolve(ListContacts::class)->execute($request);

        return response()->json($result);
    }

    public function store(CreateContactRequest $request) {
        $result = resolve(CreateContact::class)->execute($request->validated());

        return response()->json($result);
    }

    public function detail($id) {
        $result = resolve(DetailContact::class)->execute($id);

        return response()->json($result);
    }

    public function update(UpdateContactsRequest $request) {
        $result = resolve(UpdateContacts::class)->execute($request->validated());

        return response()->json($result);
    }

    public function delete(DeleteContactsRequest $request){
        resolve(DeleteContacts::class)->execute($request->validated());

        return response()->json([
            'message' => 'Delete tag success'
        ]);
    }
}
