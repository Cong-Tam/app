<?php

namespace App\Actions\Contacts;

use App\Models\Contact;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DetailContact
{
    public function execute($id)
    {
        $contact = Contact::find($id);

        if (!$contact) {
            throw new NotFoundHttpException('Contact not found');
        }

        return $contact;
    }
}
