@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit video "{{ $video->title }}"</div>

                <div class="card-body">
                    <form action="/videos/{{ $video->uid }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" name="title" value="{{ old('title') ? old('title') : $video->title }}">

                            @if ($errors->has('title'))
                                <div class="help-block">
                                    {{ $errors->first('title') }}
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" name="description" id="" cols="30" rows="10">{{ old('description') ? old('description') : $video->description }}</textarea>

                            @if ($errors->has('description'))
                                <div class="help-block">
                                    {{ $errors->first('description') }}
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="visibility">Visibility</label>
                            <select name="visibility" class="form-control" value="{{ $video->visibility }}">
                                @foreach (['private', 'unlisted', 'public'] as $item)
                                    <option value="{{ $item }}" {{ $item === $video->visibility ? "selected='selected'" : '' }}>{{ ucfirst($item) }}</option>
                                @endforeach
                            </select>

                            @if ($errors->has('visibility'))
                                <div class="help-block">
                                    {{ $errors->first('visibility') }}
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="visibility">
                                <input type="checkbox" name="allow_votes" {{ $video->votesAllowed() ? "checked='checked'" : '' }}>
                                Allow votes
                            </label>
                        </div>

                        <div class="form-group">
                            <label for="visibility">
                                <input type="checkbox" name="allow_comments" {{ $video->commentsAllowed() ? "checked='checked'" : '' }}>
                                Allow comments
                            </label>
                        </div>

                        <button type="submit" class="btn btn-default">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
