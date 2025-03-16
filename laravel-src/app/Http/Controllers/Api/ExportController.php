<?php

namespace App\Http\Controllers\Api;

use App\Actions\Exports\ExportContacts;
use App\Http\Controllers\Controller;
use App\Http\Requests\Export\ExportContactsRequest;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function exportContacts(ExportContactsRequest $request) {
        return resolve(ExportContacts::class)->execute($request->validated());
    }
}
