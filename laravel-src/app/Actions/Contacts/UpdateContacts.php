<?php

namespace App\Actions\Contacts;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateContacts
{
    public function execute($request)
    {
        $firstNameCases = [];
        $lastNameCases = [];
        $emailCases = [];
        $phoneCases = [];
        $opportunitieCases = [];
        $userIdCases = [];

        $ids = [];
        $params = [];

        foreach ($request['contacts'] as $contact) {
            $id = (int) $contact['id'];
            $ids[] = $id;

            if (isset($contact['first_name'])) {
                $firstNameCases[] = "WHEN {$id} THEN ?";
                $params[0][] = $contact['first_name'];
            }

            if (isset($contact['last_name'])) {
                $lastNameCases[] = "WHEN {$id} THEN ?";
                $params[1][] = $contact['last_name'];
            }

            if (isset($contact['email'])) {
                $emailCases[] = "WHEN {$id} THEN ?";
                $params[2][] = $contact['email'];
            }

            if (isset($contact['phone'])) {
                $phoneCases[] = "WHEN {$id} THEN ?";
                $params[3][] = $contact['phone'];
            }

            if (isset($contact['opportunity'])) {
                $opportunitieCases[] = "WHEN {$id} THEN ?";
                $params[4][] = $contact['opportunity'];
            }

            if (isset($contact['user_id'])) {
                $userIdCases[] = "WHEN {$id} THEN ?";
                $params[5][] = (int) $contact['user_id'];
            }
        }

        // dd($firstNameCases, $lastNameCases, $emailCases, $phoneCases, $opportunitieCases, $userIdCases, $params);

        $query = "UPDATE contacts SET ";
        if (!empty($firstNameCases)) {
            $query .= "`first_name` = CASE `id` " . implode(' ', $firstNameCases) . " END, ";
        }
        if (!empty($lastNameCases)) {
            $query .= "`last_name` = CASE `id` " . implode(' ', $lastNameCases) . " END, ";
        }
        if (!empty($emailCases)) {
            $query .= "`email` = CASE `id` " . implode(' ', $emailCases) . " END, ";
        }
        if (!empty($phoneCases)) {
            $query .= "`phone` = CASE `id` " . implode(' ', $phoneCases) . " END, ";
        }
        if (!empty($opportunitieCases)) {
            $query .= "`opportunity` = CASE `id` " . implode(' ', $opportunitieCases) . " END, ";
        }
        if (!empty($userIdCases)) {
            $query .= "`user_id` = CASE `id` " . implode(' ', $userIdCases) . " END, ";
        }

        $idsList = implode(',', $ids);
        $params = array_merge(...$params);
        $params[] = Auth::user()->id;
        $params[] = Carbon::now();

        $query .= "`updated_by` = ?, `updated_at` = ? WHERE `id` IN ({$idsList})";

        return DB::update($query, $params);
    }

    public function updateValues(array $values, $table)
    {
        $cases = [];
        $ids = [];
        $params = [];

        foreach ($values as $id => $value) {
            $id = (int) $id;
            $cases[] = "WHEN {$id} then ?";
            $params[] = $value;
            $ids[] = $id;
        }

        $ids = implode(',', $ids);
        $cases = implode(' ', $cases);
        $params[] = Carbon::now();

        return DB::update("UPDATE `{$table}` SET `value` = CASE `id` {$cases} END, `updated_at` = ? WHERE `id` in ({$ids})", $params);
    }
}
