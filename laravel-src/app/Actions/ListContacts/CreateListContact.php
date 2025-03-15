<?php

namespace App\Actions\ListContacts;

use App\Models\ListContact;

class CreateListContact
{
    public function execute($request)
    {
        return ListContact::create($request);
    }
}
