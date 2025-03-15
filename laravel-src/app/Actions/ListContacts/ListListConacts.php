<?php

namespace App\Actions\ListContacts;

use App\Models\ListContact;

class ListListConacts
{
    public function execute()
    {
        return ListContact::select(['id', 'name'])->get();
    }
}
