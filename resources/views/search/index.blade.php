@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Search results "{{ Request::get('q') }}"</div>

                <div class="card-body">
                    @if ($channels->count())
                        <h4>Channels</h4>

                        <div class="well">
                            @foreach ($channels as $channel)
                                <div class="media">
                                    <div style="margin-right: 5px; margin-bottom: 10px" class="media-left">
                                        <a href="/channel/{{ $channel->slug }}">
                                            <img src="{{ $channel->getImage() }}" alt="{{ $channel->name }} image" class="media-object">
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <a href="/channel/{{ $channel->slug }}" class="meadia-heading">{{ $channel->name }}</a>
                                        <ul class="list-inline">
                                            <li>{{ $channel->subcriptionCount() }} {{ str_plural('subcriber', $channel->subcriptionCount()) }}</li>
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <h4>Videos</h4>

                    @if ($videos->count())
                        @foreach ($videos as $video)
                            <div class="well">
                                @include ('video.partials._video_result', ['video' => $video])
                            </div>
                        @endforeach
                    @else
                        <p>No videos found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
