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
        $tagPivot = [];
        $listContactPivot = [];

        $ids = [];
        $params = [];

        foreach ($request['contacts'] as $contact) {
            $id = (int) $contact['id'];
            $ids[] = $id;
            if (!empty($contact['tagIds'])) {
                foreach($contact['tagIds'] as $tagId) {
                    $tagPivot[] = [
                        'contact_id' => $id, 'tag_id' => $tagId
                    ];
                }
            }

            if (!empty($contact['listContactIds'])) {
                foreach($contact['listContactIds'] as $listContactId) {
                    $listContactPivot[] = [
                        'contact_id' => $id, 'list_id' => $listContactId
                    ];
                }
            }

            if (isset($contact['firstName'])) {
                $firstNameCases[] = "WHEN {$id} THEN ?";
                $params[0][] = $contact['firstName'];
            }

            if (isset($contact['lastName'])) {
                $lastNameCases[] = "WHEN {$id} THEN ?";
                $params[1][] = $contact['lastName'];
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

            if (isset($contact['userId'])) {
                $userIdCases[] = "WHEN {$id} THEN ?";
                $params[5][] = (int) $contact['userId'];
            }
        }

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

        $this->syncPivotData($ids, $tagPivot, $listContactPivot);

        return DB::update($query, $params);
    }

    private function syncPivotData(array $contactIds, $tagPivot, $listContactPivot)
    {
        DB::table('contact_tag')->whereIn('contact_id', $contactIds)->delete();
        DB::table('contact_list')->whereIn('contact_id', $contactIds)->delete();
        DB::table('contact_tag')->insert($tagPivot);
        DB::table('contact_list')->insert($listContactPivot);
    }
}
