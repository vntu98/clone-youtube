<?php

namespace App\Models;

use App\Models\VideoView;
use App\Traits\Orderable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model
{
    use SoftDeletes, Orderable;
    
    protected $guarded = [];

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function getRouteKeyName()
    {
        return 'uid';
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

    public function scopeSearch($query, $term)
    {
        $term = '%' . $term . '%';

        return $query->where('title', 'like', $term);
    }

    public function votes()
    {
        return $this->morphMany(Vote::class, 'voteable');
    }

    public function upVotes()
    {
        return $this->votes->where('type', 'up');
    }

    public function downVotes()
    {
        return $this->votes->where('type', 'down');
    }

    public function voteFromUser($user)
    {
        return $this->votes()->where('user_id', $user->id);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->whereNull('reply_id');
    }

    public function scopeProcessed($query)
    {
        return $query->where('processed', false);
    }

    public function scopePublic($query)
    {
        return $query->where('visibility', 'public');
    }

    public function scopeVisible($query)
    {
        return $query->processed()->public();
    }
}
