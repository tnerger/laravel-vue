<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ListingImageSize extends Model
{
    protected $fillable = ['listing_image_id', 'size', 'filename'];
    protected $appends = ['src'];

    public function image(): BelongsTo
    {
        return $this->belongsTo(ListingImage::class);
    }

    public function getSrcAttribute() {
        return asset("storage/{$this->filename}");
    }

}
