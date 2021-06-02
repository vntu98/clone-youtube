@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Video</div>

                <div class="card-body">
                    @if ($videos->count())
                        @foreach ($videos as $video)
                            <div style="margin-bottom: 10px" class="row">
                                <div class="col-sm-3">
                                    <a href="/videos/{{ $video->uid }}">
                                        <img width="80" height="40" src="{{ $video->getThumbnail() }}" alt="{{ $video->title }}">
                                    </a>
                                </div>
                                <div class="col-sm-9">
                                    <a href="/videos/{{ $video->uid }}">{{ $video->title }}</a>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="muted">
                                                @if (!$video->isProcessed())
                                                    Processing ({{ $video->processingPercentage() ? $video->processingPercentage() . '%' : 'Starting up' }} )
                                                @else
                                                    <span>{{ $video->created_at->toDateTimeString() }}</span>
                                                @endif
                                            </div>

                                            <form action="/videos/{{ $video->uid }}/delete" method="post">
                                                @csrf
                                                <a href="/videos/{{ $video->uid }}/edit" class="btn btn-default">Edit</a>
                                                <button type="submit" class="btn btn-default">Delete</button>
                                            </form>
                                        </div>
                                        <div class="col-sm-6">
                                            <p>{{ ucfirst($video->visibility) }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        {{ $videos->links() }}
                    @else
                        <p>You have no videos.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
