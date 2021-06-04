<div class="row">
    <div class="col-sm-3">
        <a href="/videos/{{ $video->uid }}">
        <img width="150" height="80" src="{{ $video->getThumbnail() }}" alt="{{ $video->title }} image" class="img-responsive"></a>
    </div>

    <div class="col-sm-9">
        <a href="/videos/{{ $video->uid }}">{{ $video->title }}</a>

        @if ($video->description)
            <p>{{ $video->description }}</p>
        @else
            <p class="muted">No description</p>
        @endif

        <ul class="list-inline">
            <li style="display: inline-block; margin-right: 6px"><a href="/channel/{{ $video->channel->slug }}">{{ $video->channel->name }}</a></li>
            <li style="display: inline-block; margin-right: 6px">{{ $video->created_at->diffForHumans() }}</li>
            <li style="display: inline-block">{{ $video->viewCount() }} {{ str_plural('view', $video->viewCount()) }}</li>
        </ul>
    </div>
</div>