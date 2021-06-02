<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function getImage()
    {
        if (!$this->image_filename) {
            return config('codetube.buckets.videos') . '/default.jpeg';
        }

        return config('codetube.buckets.images') . '/profile/' . $this->image_filename;
    }
}
