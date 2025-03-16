<?php

namespace App\Services\Filters;

use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    public function scopeFilter(Builder $builder, BaseFilter $filter): Builder
    {
        return $filter->apply($builder);
    }
}
