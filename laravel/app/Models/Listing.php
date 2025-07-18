<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Listing extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['beds', 'city', 'baths', 'area', 'code', 'street', 'street_nr', 'price'];
    protected $sortable = ['price', 'created_at'];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeMostRecent(Builder $query): Builder
    {
        return $query->orderByDesc('created_at');
    }

    public function scopeSort(Builder $query, array $sort): Builder
    {
        return $query->when(
            $sort['by'] ?? false,
            fn($query, $value) =>
            !in_array($value, $this->sortable) ? $query :
                $query->orderBy($value, $sort['order'] ?? 'desc')
        );
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when(
                $filters['priceFrom'] ?? false,
                fn($query, $value) => $query->where('price', '>=', $value)
            )
            ->when(
                $filters['priceTo'] ?? false,
                fn($query, $value) => $query->where('price', '<=', $value)
            )
            ->when(
                $filters['baths'] ?? false,
                fn($query, $value) => $query->where('baths', (int)$value < 6 ? '=' : '>=', $value)
            )
            ->when(
                $filters['beds'] ?? false,
                fn($query, $value) => $query->where('beds', (int)$value < 6 ? '=' : '>=', $value)
            )
            ->when(
                $filters['areaFrom'] ?? false,
                fn($query, $value) => $query->where('area', '>=', $value)
            )
            ->when(
                $filters['areaTo'] ?? false,
                fn($query, $value) => $query->where('area', '<=', $value)
            );
    }
}
