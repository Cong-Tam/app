<?php

namespace App\Actions\Contacts;

use App\Models\Contact;
use Illuminate\Support\Facades\Auth;

class ListContacts
{
    private $contact;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    public function execute($request)
    {
        return $this->contact
            ->with([
                'user:id,first_name,avatar',
                'tags:name,color',
                'listContacts:name'
            ])
            ->get();
    }
}
