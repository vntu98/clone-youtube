@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    <div class="media">
                        <div class="media-left">
                            <img style="margin-right: 5px" src="{{ $channel->getImage() }}" alt="{{ $channel->name }} image" class="media-object">
                        </div>
                        <div class="media-body">
                            {{ $channel->name }}

                            <ul class="list-inline">
                                <li style="display: inline-block; margin-right: 5px;">
                                    <subcribe-button channel-slug={{ $channel->slug }}></subcribe-button>
                                </li>
                                <li style="display: inline-block;">
                                    {{ $channel->totalVideoViews() }} video {{ str_plural('view', $channel->totalVideoViews()) }}
                                </li>
                            </ul>

                            @if ($channel->description)
                                <hr>
                                <p>{{ $channel->description }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div style="margin-top: 10px" class="card">
                <div class="card-header">Videos</div>

                <div class="card-body">
                    @if ($videos->count())
                        @foreach ($videos as $video)
                            <div class="well">
                                @include('video.partials._video_result', ['video' => $video])
                            </div>
                        @endforeach

                        {{ $videos->links() }}
                    @else
                        <p>{{$channel->name}} has no videos</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
