<?php

namespace App\Policies;

use App\Models\Channel;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChannelPolicy
{
    use HandlesAuthorization;

    public function edit(User $user, Channel $channel)
    {
        return $user->id === $channel->user_id;
    }

    public function update(User $user, Channel $channel)
    {
        return $user->id === $channel->user_id;
    }

    public function subcribe(User $user, Channel $channel)
    {
        if ($user->isSubcribedTo($channel)) {
            return false;
        }
        
        return !$user->ownsChannel($channel);
    }

    public function unsubcribe(User $user, Channel $channel)
    {
        return $user->isSubcribedTo($channel);
    }
}
