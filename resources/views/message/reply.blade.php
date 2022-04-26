@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reply to Message') }}</div>
                <div class="card-body">
                    <p>{{ $message->body }}</p>
                   <form method="POST" action="/reply-to-message">
                        @csrf
                        <label>Response:</label>
                        <textarea class="form-control" name="body"></textarea>
                        <br>
                        <button type="submit" class="btn btn-primary">Post</button>
                        <input type="hidden" name="replyToId" value="{{ $message->id }}">
                   </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
