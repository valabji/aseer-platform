<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetaineePhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'detainee_id',
        'is_featured',
        'path',
    ];

    /**
     * علاقة الصورة بالمعتقل
     */
    public function detainee()
    {
        return $this->belongsTo(Detainee::class);
    }

    /**
     * Get the URL attribute for the photo.
     *
     * @return string
     */
    public function getUrlAttribute(): string
    {
        return asset('storage/public/' . $this->path);
    }

    public function getFeaturedUrlAttribute(): string
    {
        return asset('storage/public/' . $this->path);
    }

    /**
     * Check if the photo is featured.
     *
     * @return bool
     */
    public function getIsFeaturedAttribute(): bool
    {
        return (bool) $this->attributes['is_featured'];
    }


    /**
     * Scope a query to only include featured photos.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
    /**
     * Scope a query to only include non-featured photos.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNonFeatured($query)
    {
        return $query->where('is_featured', false);
    }
}
