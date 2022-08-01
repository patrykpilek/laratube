<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'title',
        'description',
        'path',
    ];

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }
}
