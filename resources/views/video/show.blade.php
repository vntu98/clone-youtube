@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

            @if ($video->isPrivate() && Auth::check() && $video->ownedByUser(Auth::user()))
                <div class="alert alert-info">
                    Your video is currently private. Only you can see it
                </div>
            @endif

            @if ($video->isProcessed() && $video->canBeAccessed(Auth::user()))
                <video-player video-uid="{{ $video->uid }}" video-url="{{ $video->getStreamUrl() }}" thumbnail-url="{{ $video->thumbnail }}"></video-player>
            @endif

            @if (!$video->isProcessed())
                <div class="video-placeholder">
                    <div class="video-laceholder__header">
                        The video is processing. Come back a bit later
                    </div>
                </div>
            @elseif (!$video->canBeAccessed(Auth::user()))
                <div class="video-placeholder">
                    <div class="video-laceholder__header">
                        The video is private
                    </div>
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <h4>{{ $video->title }}</h4>
                    <div class="pull-right">
                        <div class="video__views">
                            {{ $video->viewCount() }} {{ str_plural('view', $video->viewCount()) }}

                            <video-voting video-uid={{ $video->uid }}></video-voting>
                        </div>
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
                        <video-comments video-uid={{ $video->uid }}></video-comments>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
