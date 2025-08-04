<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ListingImage extends Model
{
    use HasFactory;

    protected $fillable = ['sort', 'is_cover'];

    protected $with = ['sizes']; // Die Größen sollen immer mitgeladen werden, das man das Bidl sonst eh nicht verwenden kann
    public $file_sizes = [
        'small' => 300,
        'medium' => 600,
        'large' => 1200,
    ];
    protected $appends = ['sizes_by_key']; // Das Ausgabearray soll immer size als Index nutzen. Ist dann im Frontend einfach aufzurufen

    public function getSizesByKeyAttribute()
    {
        return $this->sizes->keyBy('size')->toArray();
    }

    public function listing(): BelongsTo
    {
        return $this->belongsTo(Listing::class);
    }

    public function sizes(): HasMany
    {
        return $this->hasMany(ListingImageSize::class);
    }
}
