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

<div class="row dotted">
    <div class="span6 offset6">
        {{ Former::five_text('username')->name('username') }} 
        {{ Former::five_password('password')->name('password') }}                    
        
        {{ Former::actions()->primary_submit('Log In') }}
    </div>
</div>
<div class="row">
    <div class="span6 offset6">
        <p>
            <a href="{{ URL::to('connect/facebook')}}" class="soc-signup"><i class="icon-facebook-sign"></i> Log in with Facebook</a>
            <a href="{{ URL::to('connect/linkedin')}}" class="soc-signup"><i class="icon-linkedin-sign"></i> Log in with Linkedin</a>
        </p>
    </div>
</div>

{{ Former::close() }}

@stop