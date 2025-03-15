<?php

namespace App\Actions\ListContacts;

use App\Models\ListContact;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DetailListContact
{
    public function execute($id)
    {
        $listContact = ListContact::find($id);

        if (!$listContact) {
            throw new NotFoundHttpException('ListContact not found');
        }

        return $listContact;
    }
}
