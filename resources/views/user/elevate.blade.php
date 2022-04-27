@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Manage Admins') }}</div>
                <div class="card-body">
                    <h2>Users</h2>
                    @foreach($users as $user)
                    <table>
                        <tr>
                            <td width="80%">{{ $user->name }}</td>
                            <td><a class="btn btn-primary" href="/promote-user/{{ $user->id }}">Promote</a></td>
                        </tr>
                    </table>
                    
                   
                    @endforeach
                    <hr>
                    <h2>Admins</h2>
                    @foreach($admins as $admin)

                    <table>
                        <tr>
                            <td width="80%">{{ $admin->name }}</td>
                            <td><a class="btn btn-primary" href="/demote-user/{{ $admin->id }}">Demote</a></td>
                        </tr>
                    </table>
                   
                    @endforeach
                </div>


            </div>
           


        </div>
    </div>
</div>
@endsection
