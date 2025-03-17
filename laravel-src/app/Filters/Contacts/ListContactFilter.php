<?php

namespace App\Filters\Contacts;

use App\Services\Filters\BaseFilter;


class ListContactFilter extends BaseFilter
{
    public function filterCreatedBy($createdById)
    {
        return $this->builder->where('created_by', $createdById);
    }

    public function filterCreatedAt($createdAt)
    {
        return $this->builder->where('created_at', $createdAt);
    }

    public function filterUserId($userId)
    {
        return $this->builder->where('user_id', $userId);
    }

    public function filterEmail($email)
    {
        return $this->builder->where('email', 'like', "%$email%");
    }

    public function filterName($name)
    {
        return $this->builder->where(function ($query) use ($name) {
            $query->where('first_name', 'like', "%$name%")
                ->orWhere('last_name', 'like', "%$name%");
        });
    }

    public function filterTagId($tagId)
    {
        return $this->builder->whereHas('tags', function ($query) use ($tagId) {
            $query->where('tag_id', $tagId);
        });
    }

    public function filterListId($listId)
    {
        return $this->builder->whereHas('listContacts', function ($query) use ($listId) {
            $query->where('list_id', $listId);
        });
    }
}
