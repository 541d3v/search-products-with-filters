<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'price',
        'category_id',
        'in_stock',
        'rating',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'in_stock' => 'boolean',
        'rating' => 'float',
        'price' => 'decimal:2',
    ];

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): Factory
    {
        return ProductFactory::new();
    }

    /**
     * Get the category that owns the product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Scope to filter by name (search).
     */
    public function scopeByName($query, $name)
    {
        if (! $name) {
            return $query;
        }

        return $query->where('name', 'like', '%'.$name.'%');
    }

    /**
     * Scope to filter by price range.
     */
    public function scopeByPriceRange($query, $minPrice = null, $maxPrice = null)
    {
        if ($minPrice !== null) {
            $query->where('price', '>=', $minPrice);
        }

        if ($maxPrice !== null) {
            $query->where('price', '<=', $maxPrice);
        }

        return $query;
    }

    /**
     * Scope to filter by category.
     */
    public function scopeByCategory($query, $categoryId)
    {
        if (! $categoryId) {
            return $query;
        }

        return $query->where('category_id', $categoryId);
    }

    /**
     * Scope to filter by stock status.
     */
    public function scopeByStockStatus($query, $inStock)
    {
        if ($inStock === null) {
            return $query;
        }

        return $query->where('in_stock', $inStock);
    }

    /**
     * Scope to filter by minimum rating.
     */
    public function scopeByMinRating($query, $minRating = null)
    {
        if ($minRating === null) {
            return $query;
        }

        return $query->where('rating', '>=', $minRating);
    }

    /**
     * Scope to sort results.
     */
    public function scopeWithSort($query, $sort = 'newest')
    {
        return match ($sort) {
            'price_asc' => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'rating_desc' => $query->orderBy('rating', 'desc'),
            'newest' => $query->orderBy('created_at', 'desc'),
            default => $query->orderBy('created_at', 'desc'),
        };
    }
}
