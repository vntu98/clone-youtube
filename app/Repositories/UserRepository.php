<?php

namespace App\Repositories;

use App\User;

class UserRepository
{
    public function videosFromSubcriptions(User $user, $limit = 5)
    {
        return $user->subcribedChannels()->with(['videos' => function ($query) use ($limit) {
            $query->visible()->take($limit);
        }])->get()->pluck('videos')->flatten()->sortByDesc('created_at');
    }
}