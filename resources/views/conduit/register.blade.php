@extends('Unauth_layout')
@section('title', 'Sign up | ')
@section('content')
<div class="auth-page">
    <div class="container page">
        <div class="row">
        <div class="col-md-6 offset-md-3 col-xs-12">
            <h1 class="text-xs-center">Sign up</h1>
            <p class="text-xs-center">
            <a href="/signIn">Have an account?</a>
            </p>

            @if ($errors->any())
                <ul class="error-messages">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <form method="POST" action="{{ route('register') }}">
            @csrf
            <fieldset class="form-group">
                <input class="form-control form-control-lg" type="text" placeholder="Username" name="name"/>
            </fieldset>
            <fieldset class="form-group">
                <input class="form-control form-control-lg" type="text" placeholder="Email" name="email"/>
            </fieldset>
            <fieldset class="form-group">
                <input class="form-control form-control-lg" type="password" placeholder="Password" name="password"/>
            </fieldset>
            <button type="submit" class="btn btn-lg btn-primary pull-xs-right">Sign up</button>
            </form>
        </div>
        </div>
    </div>
</div>
@endsection
