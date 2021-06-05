<?php

namespace App\Transformers;

use App\Models\Channel;
use League\Fractal\TransformerAbstract;

class ChannelTransformer extends TransformerAbstract
{
    protected $avaibleIncludes = [
        'channel'
    ];

    public function transform(Channel $channel)
    {
        return [
            'id' => $channel->id,
            'slug' => $channel->slug,
            'image' => $channel->getImage(),
            'name' => $channel->name
        ];
    }
}