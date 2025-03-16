<?php

namespace App\Actions\Contacts;

use App\Models\Contact;
use Illuminate\Support\Facades\Auth;

class CreateContact
{
    public function execute($request)
    {
        return Contact::create([
            ...$request,
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id,
        ]);
    }
}
