<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use Illuminate\Http\Request;

class ChannelSubcriptionController extends Controller
{
    public function show(Request $request, Channel $channel)
    {
        $response = [
            'count' => $channel->subcriptionCount(),
            'user_subcribed' => false,
            'can_subcribe' => false
        ];

        if ($request->user()) {
            $response = array_merge($response, [
                'user_subcribed' => $request->user()->isSubcribedTo($channel),
                'can_subcribe' => !$request->user()->ownsChannel($channel)
            ]);
        }

        return response()->json($response, 200);
    }

    public function create(Request $request, Channel $channel)
    {   
        $this->authorize('subcribe', $channel);

        $request->user()->subcriptions()->create([
            'channel_id' => $channel->id
        ]);

        return response()->json(null, 200);
    }

    public function delete(Request $request, Channel $channel)
    {
        $this->authorize('unsubcribe', $channel);

        $request->user()->subcriptions()->where('channel_id', $channel->id)->delete();

        return response()->json(null, 200);
    }
}
