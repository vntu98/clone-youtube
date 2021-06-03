<?php

namespace App\Models;

use App\Models\VideoView;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

class Video extends Model
{
    use SoftDeletes;
    
    protected $guarded = [];

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function getRouteKeyName()
    {
        return 'uid';
    }

    public function scopeLatestFirst($builder)
    {
        return $builder->latest();
    }

    public function isProcessed()
    {
        return $this->processed == 0;
    }

    public function processingPercentage()
    {
        return $this->processed_percentage;
    }

    public function getThumbnail()
    {
        if (!$this->isProcessed()) {
            return config('codetube.buckets.videos') . '/default.jpeg';
        }

        return config('codetube.buckets.videos') . '/default.jpeg';
    }

    public function votesAllowed()
    {
        return (bool) $this->allow_votes;
    }

    public function commentsAllowed()
    {
        return (bool) $this->allow_comments;
    }

    public function isPrivate()
    {
        return $this->visibility === 'private';
    }

    public function ownedByUser($user)
    {
        return $this->channel->user_id === $user->id;
    }

    public function canBeAccessed($user = null)
    {
        if (!$user && $this->isPrivate()) {
            return false;
        }

        if ($user && ($user->id !== $this->channel->user_id)) {
            return false;
        }

        return true;
    }

    public function getStreamUrl()
    {
        return config('codetube.buckets.videos') . '/' . $this->video_filename;
    }

    public function views()
    {
        return $this->hasMany(VideoView::class);
    }

    public function viewCount()
    {
        return $this->views->count();
    }
}
