@extends('layouts.signin')

@section('content')


    {{ Former::horizontal_open()->id('login')->method('POST')->class('form-signin'); }}
        <h2 class="form-signin-heading">Please sign in</h2>
        @if (Session::has('login_errors'))
            <div class="alert alert-error">
                 <button type="button" class="close" data-dismiss="alert"></button>
                 Email or password incorrect.
            </div>
        @endif

        {{ Former::five_text('username')->name('username')->label('E-mail')->class('input-block-level')->placeholder('you@email.com') }}
        {{ Former::five_password('password')->name('password')->class('input-block-level')->placeholder('password') }}

        <label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
        </label>
        <button class="btn btn-primary" type="submit">
           Sign in
           <i class="icon-circle-arrow-right"></i>
        </button>
    {{ Former::close() }}

@stop