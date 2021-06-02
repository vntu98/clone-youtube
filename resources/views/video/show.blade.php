@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Video player</div>

                <div class="card-body">
                    <h4>{{ $video->title }}</h4>
                    <div class="pull-right">
                        Video views
                    </div>

                    <div class="media">
                        <div class="media-left">
                            <a href="/channel/{{ $video->channel->slug }}">
                                <img src="{{ $video->channel->getImage() }}" alt="{{ $video->channel->name }} image">
                            </a>
                        </div>
                        <div style="margin-left: 5px" class="media-body">
                            <a href="/channel/{{ $video->channel->slug }}" class="media-heading">{{ $video->channel->name }}</a>
                            Subcribe button
                        </div>
                    </div>
                </div>
            </div>
            @if ($video->description)
                <div style="margin-top: 10px" class="card">
                    <div class="card-body">
                        {!! nl2br($video->description) !!}
                    </div>
                </div>
            @endif

            <div style="margin-top: 10px" class="card">
                <div class="card-body">
                    @if ($video->commentsAllowed())
                        Comments
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
