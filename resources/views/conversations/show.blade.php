@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('conversations.users', ['users' => $users])
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">{{ $user->name }}</div>
                    <div cass="card-body conversations">
                        <form action="" method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <textarea name="content" placeholder="Ecrivez votre message" class="form-control"></textarea>
                                <button class="btn btn-primary" type="submit">Envoyer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
