<?php

namespace App\Actions\ListContacts;

class UpdateListContact
{
    public function execute($request, $id)
    {
        $listContact = resolve(DetailListContact::class)->execute($id);

        return tap($listContact)->update($request);
    }
}
