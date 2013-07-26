@extends('layouts.front')


@section('content')

<h4>{{$company['companyName']}}</h4>

<div class="row">
    <div class="span6">
        <dl>
            <dt>Company Name</dt>
            <dd>{{ $company['companyName']}}</dd>

            <dt>Company Category</dt>
            <dd>{{ $company['mainCategory']}}</dd>

            <dt>Country (HQ)</dt>
            <dd>{{ $company['countryHQ']}}</dd>

            <dt>Website</dt>
            <dd>{{ $company['website']}}</dd>

            <dt>Email (Main)</dt>
            <dd>{{ $company['email']}}</dd>
        </dl>
    </div>
    <div class="span6">
        <dl>
            <dt>Expertise & Skills</dt>
            <dd>{{ $company['expertise']}}</dd>

            <dt>About</dt>
            <dd>{{ $company['about']}}</dd>
        </dl>
    </div>
</div>

<div class="row">
    <div class="span6">
        <h5>Offices & Showrooms</h5>
    </div>
    <div class="span6">
        <h5>Distributors & Agents</h5>
    </div>
</div>

@stop