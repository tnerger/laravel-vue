<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ListingImage extends Model
{
    protected $fillable = ['filename'];

    public function listing(): BelongsTo
    {
        return $this->belongsTo(Listing::class);
    }
}
