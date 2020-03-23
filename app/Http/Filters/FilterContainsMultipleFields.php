<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FilterContainsMultipleFields implements Filter
{
    /** @var array */
    private $fields;

    public function __construct(array $fields)
    {
        $this->fields = $fields;
    }

    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where(function (Builder $query) use ($value) {
            foreach ($this->fields as $field) {
                $query->orWhere($field, 'LIKE', '%' . $value . '%');
            }
        });

        return $query;
    }
}
