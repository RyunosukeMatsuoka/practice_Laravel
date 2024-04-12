@extends('Unauth_layout')
@section('title', 'Sign in | ')
@section('content')
<div class="auth-page">
    <div class="container page">
        <div class="row">
        <div class="col-md-6 offset-md-3 col-xs-12">
            <h1 class="text-xs-center">Sign in</h1>
            <p class="text-xs-center">
            <a href="/signUp">Need an account?</a>
            </p>

            <ul class="error-messages">
            </ul>

            <form method="POST" action="{{ route('login') }}">
            <fieldset class="form-group">
                <input class="form-control form-control-lg" type="text" placeholder="Email" name="email"/>
            </fieldset>
            <fieldset class="form-group">
                <input class="form-control form-control-lg" type="password" placeholder="Password" name="password"/>
            </fieldset>
            <button type="submit" class="btn btn-lg btn-primary pull-xs-right">Sign in</button>
            </form>
        </div>
        </div>
    </div>
</div>
@endsection
