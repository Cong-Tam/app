<?php

namespace App\Actions\Exports;

use App\Enums\ExportType;
use App\Exports\ContactsExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportContacts
{
    public function execute($request)
    {
        $fileName = $request['name'] . ExportType::tryFrom($request['type'])->extension();
        $cols = $request['isAll'] ? [] : $request['cols'];

        return Excel::download(new ContactsExport($cols), $fileName);
    }
}
