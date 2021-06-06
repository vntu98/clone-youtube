<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Subcription extends Model
{
    protected $fillable = [
        'channel_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
