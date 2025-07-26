<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = ['amount','accepted_at', 'rejected_at'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function listing(): BelongsTo
    {
        return $this->belongsTo(Listing::class);
    }

    public function scopebyActiveUser(Builder $query): Builder
    {
        return $query->where('user_id', Auth::user()?->id);
    }
}
