<?php

namespace App\Actions\Contacts;

use App\Filters\Contacts\ListContactFilter;
use App\Models\Contact;

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
            ->filter(new ListContactFilter($request))
            ->get();
    }
}
