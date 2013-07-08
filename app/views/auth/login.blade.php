@extends('layouts.front')

@section('content')

@if (Session::has('login_errors'))
    <div class="row">
        <div class="alert alert-error">
             <button type="button" class="close" data-dismiss="alert"></button>
             Email or password incorrect.
        </div>
    </div>
@endif

{{ Former::horizontal_open()->id('login')->method('POST'); }}

<div class="row">
    <div class="span6 offset3" >
        {{ Former::five_text('username')->name('username') }}
        {{ Former::five_password('password')->name('password') }}                    
        
        {{ Former::actions()->primary_submit('Log In') }}
    </div>
</div>

{{ Former::close() }}

@stop