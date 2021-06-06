@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if ($subcriptionVideos->count())
                        @foreach ($subcriptionVideos as $video)
                            <div class="well">
                                @include('video.partials._video_result', ['video' => $video])
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
