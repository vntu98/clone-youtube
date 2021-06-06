<?php

namespace App;

use App\Models\Channel;
use App\Models\Subcription;
use App\Models\Video;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function channels()
    {
        return $this->hasMany(Channel::class);
    }

    public function videos()
    {
        return $this->hasManyThrough(Video::class, Channel::class);
    }

    public function subcriptions()
    {
        return $this->hasMany(Subcription::class);
    }

    public function subcribedChannels()
    {
        return $this->belongsToMany(Channel::class, 'subcriptions');
    }

    public function isSubcribedTo(Channel $channel)
    {
        return (bool) $this->subcriptions->where('channel_id', $channel->id)->count();
    }

    public function ownsChannel(Channel $channel)
    {
        return (bool) $this->channels->where('id', $channel->id)->count();
    }
}
