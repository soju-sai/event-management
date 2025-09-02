<?php

namespace App\Http\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait CanLoadRelationships {
    public function loadRelationship
    (
        Model|QueryBuilder|EloquentBuilder|HasMany $for,
        ?Array $relations = null
    )
    {
        $relations = $this->relations ?? $relations ?? [];

        foreach ($relations as $relation) {
            $for->when(
                $this->shouldHaveRelationship($relation),
                fn($q) => $for instanceof Model ? $for->load($relation) : $q->with($relation)
            );
        }

        return $for;
    }

    protected function shouldHaveRelationship(string $relation): bool {
        $include = request()->query('include');

        if (! $include) {
            return false;
        }

        $relations = explode(',', $include);

        return in_array($relation, $relations);
    }
}
