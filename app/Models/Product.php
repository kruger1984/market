<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\HasFilter;
use App\Observers\ProductObserver;
use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;

/**
 * @property array<int|string, mixed> $grouped_params
 */
#[ObservedBy(ProductObserver::class)]
class Product extends Model
{
    /** @use HasFactory<ProductFactory> */
    use HasFactory;

    /** @use HasFilter<static> */
    use HasFilter;

    /**
     * @return HasMany<Image, $this>
     */
    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    /**
     * @return HasMany<ParamProduct, $this>
     */
    public function paramProducts(): HasMany
    {
        return $this->hasMany(ParamProduct::class);
    }

    /**
     * @return BelongsTo<ProductGroup, $this>
     */
    public function productGroup(): BelongsTo
    {
        return $this->belongsTo(ProductGroup::class);
    }

    /**
     * @return BelongsTo<Category, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getPreviewImageUrlAttribute(): ?string
    {
        return $this->images->first()->url ?? null;
    }

    /**
     * @return BelongsTo<Product, $this>
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id', 'id');
    }

    /**
     * @return HasMany<Product, $this>
     */
    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    /**
     * @return BelongsToMany<Param, $this>
     */
    public function params(): BelongsToMany
    {
        return $this->belongsToMany(Param::class)->withPivot('value');
    }

    /**
     * @param  Builder<Product>  $builder
     * @param  Collection<int, Category>  $categoryChildren
     * @return Builder<Product>
     */
    public function scopeByCategories(Builder $builder, Collection $categoryChildren): Builder
    {
        return $builder->whereIn('category_id', $categoryChildren->pluck('id'))
            ->whereNotNull('parent_id')
            ->with(['images', 'params', 'children']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection<int, Product>
     */
    public function getGroupProductsAttribute(): Collection
    {
        return $this->productGroup->products()->whereNot('parent_id', $this->parent_id)->distinct('parent_id')->get();
    }

    public function getHasChildrenAttribute(): bool
    {
        return $this->children->contains('id', $this->id);
    }

    /**
     * @return HasOne<Cart, $this>
     */
    public function cart(): HasOne
    {
        return $this->hasOne(Cart::class)->where('user_id', auth()->user()->id)
            ->whereNull('order_id');
    }

    /**
     * @return HasMany<Product, Product>
     */
    public function siblingProducts(): HasMany
    {
        return $this->parent->children();
    }
}
