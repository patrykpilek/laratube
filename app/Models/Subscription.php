<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'user_id',
        'channel_id',
    ];

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }
}
