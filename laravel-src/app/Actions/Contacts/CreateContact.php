<?php

namespace App\Actions\Contacts;

use App\Models\Contact;
use Illuminate\Support\Facades\Auth;

class CreateContact
{
    public function execute($request)
    {
        $contact = Contact::create([
            'first_name'  => $request['firstName'],
            'last_name'   => $request['lastName'],
            'email'       => $request['email'],
            'phone'       => $request['phone'],
            'opportunity' => $request['opportunity'],
            'user_id'     => $request['userId'],
            'created_by'  => Auth::user()->id,
            'updated_by'  => Auth::user()->id,
        ]);

        if (!empty($request['tagIds'])) {
            $contact->tags()->attach($request['tagIds']);
        }

        if (!empty($request['listContactIds'])) {
            $contact->listContacts()->attach($request['listContactIds']);
        }

        return $contact;
    }
}
