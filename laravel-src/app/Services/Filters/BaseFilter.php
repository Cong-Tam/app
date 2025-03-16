<?php

namespace App\Services\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class BaseFilter
{
    /**
     * @var array
     */
    protected array $filters;

    /**
     * @var object $builder
     */
    protected object $builder;

    /**
     * @var array $filterable
     */
    protected array $filterable;

    /**
     * QueryFilter constructor.
     */
    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    /**
     * @param Builder $builder
     * @return Builder
     */
    public function apply(Builder $builder): Builder
    {
        $this->builder = $builder;

        foreach ($this->filters as $name => $value) {
            if ($value == '') {
                continue;
            }

            // Filter function
            $method = 'filter' . Str::studly($name);

            if (method_exists($this, $method)) {
                $this->{$method}($value);
                continue;
            }

            // Filterable
            if (empty($this->filterable) || !count($this->filterable)) {
                continue;
            }

            if (in_array($name, $this->filterable)) {
                $this->builder->where($name, $value);
            }
        }

        return $this->builder;
    }
}
