<?php

namespace App\Models;

use App\Services\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory, SoftDeletes, Filterable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'opportunity',
        'user_id',
        'created_by',
        'updated_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'contact_tag', 'contact_id', 'tag_id');
    }

    public function listContacts()
    {
        return $this->belongsToMany(ListContact::class, 'contact_list', 'contact_id', 'list_id');
    }
}
