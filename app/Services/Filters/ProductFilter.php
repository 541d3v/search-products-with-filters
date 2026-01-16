<?php

namespace App\Services\Filters;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;

class ProductFilter
{
    /**
     * Apply all filters to the query.
     *
     * @param  array<string, mixed>  $filters
     */
    public static function apply(Builder $query, array $filters): Builder
    {
        return $query
            ->when(
                isset($filters['q']) && $filters['q'],
                fn (Builder $q) => $q->byName($filters['q'])
            )
            ->when(
                isset($filters['price_from']) || isset($filters['price_to']),
                fn (Builder $q) => $q->byPriceRange(
                    $filters['price_from'] ?? null,
                    $filters['price_to'] ?? null
                )
            )
            ->when(
                isset($filters['category_id']) && $filters['category_id'],
                fn (Builder $q) => $q->byCategory($filters['category_id'])
            )
            ->when(
                isset($filters['in_stock']),
                fn (Builder $q) => $q->byStockStatus($filters['in_stock'])
            )
            ->when(
                isset($filters['rating_from']) && $filters['rating_from'],
                fn (Builder $q) => $q->byMinRating($filters['rating_from'])
            )
            ->withSort($filters['sort'] ?? 'newest');
    }
}
