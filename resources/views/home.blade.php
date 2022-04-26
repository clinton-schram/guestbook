@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Message</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($messages as $message)
                                <tr>
                                    <td>{{ $message->body }}</td>
                                    <td><a class="btn btn-secondary" href="/edit-message/{{ $message->id }}">edit</a></td>
                                    <td><a class="btn btn-danger" href="/delete-message/{{ $message->id }}">delete</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <a class="btn btn-primary" href="/create-message">Create Message</a>
                    </div>      
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
