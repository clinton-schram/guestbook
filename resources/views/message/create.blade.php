@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Create New Message') }}</div>
                <div class="card-body">
                   <form method="POST" action="/create-message">
                        @csrf
                        <textarea class="form-control" name="body"></textarea>
                        <br>
                        <button type="submit" class="btn btn-primary">Post</button>
                   </form>
                </div>
            </div>
           


        </div>
    </div>
</div>
@endsection
