<?php

namespace App\Actions\Contacts;

use App\Models\Contact;
use Illuminate\Support\Facades\Auth;

class DeleteContacts
{
    public function execute($request)
    {
        return Contact::whereIn('id', $request['contactIds'])->delete();
    }
}
