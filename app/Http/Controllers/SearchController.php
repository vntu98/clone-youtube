<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Video;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->q) {
            return redirect('/');
        }

        $channels = Channel::query()->search($request->q)->take(2)->get();
        $videos = Video::query()->search($request->q)->get();

        return view('search.index', compact('channels', 'videos'));
    }
}
