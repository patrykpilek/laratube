<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Channel extends Model implements HasMedia
{
    use HasFactory, Uuids, InteractsWithMedia;

    protected $fillable = [
        'name',
        'description',
        'image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function image()
    {
        if ($this->media->first()) {
            return $this->media->first()->getFullUrl('thumb');
        }

        return null;
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->fit(Manipulations::FIT_CROP, 160, 160)
            ->nonQueued();
    }
}
