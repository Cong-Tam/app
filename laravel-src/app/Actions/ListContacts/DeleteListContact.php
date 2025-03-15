<?php

namespace App\Actions\ListContacts;

class DeleteListContact
{
    public function execute($id)
    {
        $listContact = resolve(DetailListContact::class)->execute($id);

        return $listContact->delete();
    }
}
