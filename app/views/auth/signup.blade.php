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

{{ Former::horizontal_open()->id('signup')->method('POST'); }}

<div class="row dotted">
    <div class="span6">
        {{ Former::five_text('email')->name('Email') }} 

        {{ Former::five_text('firstname')->name('First Name') }}                    
        {{ Former::five_text('lastname')->name('Last Name') }}                    

    </div>
	<div class="span6">

        {{ Former::five_password('pass')->name('Password') }}                    
        {{ Former::five_password('repass')->name('Confirm Password') }}

        {{ Former::checkbox('agreetnc')->name('')->text('I Agree to Studio Elves terms & conditions')->checked() }}

        {{ Former::actions()->primary_submit('Sign Up') }}
	</div>
</div>
<div class="row">
    <div class="span6 offset6">
        <p>
            <a href="{{ URL::to('connect/facebook')}}" class="soc-signup"><i class="icon-facebook-sign"></i> Sign up with Facebook</a>
            <a href="{{ URL::to('connect/linkedin')}}" class="soc-signup"><i class="icon-linkedin-sign"></i> Sign up with Linkedin</a>
        </p>
    </div>
</div>
{{ Former::close() }}


@stop