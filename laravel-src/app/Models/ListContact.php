<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function contacts()
    {
        return $this->belongsToMany(Contact::class, 'contact_list', 'list_id', 'contact_id');
    }
}
