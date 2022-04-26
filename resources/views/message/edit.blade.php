@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Create New Message') }}</div>
                <div class="card-body">
                   <form method="POST" action="/edit-message/{{ $message->id }}">
                        @csrf
                        <textarea class="form-control" name="body">{{ $message->body }}</textarea>
                        <br>
                        <button type="submit" class="btn btn-primary">Post</button>
                   </form>
                </div>
            </div>
           


        </div>
    </div>
</div>
@endsection
