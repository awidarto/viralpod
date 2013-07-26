@extends('layouts.front')


@section('content')

<h3>{{$title}}</h3>

{{Former::open_for_files($submit,'POST',array('class'=>'custom addAttendeeForm'))}}

<div class="row">
    <div class="span6">

        {{ Former::select('mainCategory','Company Category')->options(Config::get('se.company_categories')) }}
        {{ Former::text('companyName','Company Name') }}
        {{ Former::select('countryHQ')->options(Config::get('country.countries'))->label('Country (HQ)') }}
        {{ Former::text('website','Website') }}
        {{ Former::text('email','Email (Main)') }}

    </div>
    <div class="span6">
        {{ Former::text('expertise','Expertise & Skills') }}
        {{ Former::textarea('about','About') }}
    </div>
</div>

<div class="row right">
    <div class="span12">
        {{ Form::submit('Save',array('class'=>'btn primary'))}}&nbsp;&nbsp;
        {{ HTML::link($back,'Cancel',array('class'=>'btn'))}}
    </div>
</div>
{{Former::close()}}

{{ HTML::script('js/wysihtml5-0.3.0.min.js') }}
{{ HTML::script('js/parser_rules/advanced.js') }}

<script type="text/javascript">

$(document).ready(function() {

    $('select').select2({
      width : 'resolve'
    });

    $('#field_role').change(function(){
        //alert($('#field_role').val());
        // load default permission here
    });

    /*
    var editor = new wysihtml5.Editor('about', { // id of textarea element
      toolbar:      'wysihtml5-toolbar', // id of toolbar element
      parserRules:  wysihtml5ParserRules // defined in parser rules set
    });
    */

    $('#name').keyup(function(){
        var title = $('#name').val();
        var slug = string_to_slug(title);
        $('#permalink').val(slug);
    });

    $('#color_input').colorPicker();

    // dynamic tables
    $('#add_btn').click(function(){
        //alert('click');
        addTableRow($('#variantTable'));
        return false;
    });

    // custom field table
    $('#custom_add_btn').click(function(){
        //alert('click');
        addTableRow($('#customTable'));
        return false;
    });

    $('#related_add_btn').click(function(){
        //alert('click');
        addTableRow($('#relatedTable'));
        return false;
    });

    $('#component_add_btn').click(function(){
        //alert('click');
        addTableRow($('#componentTable'));
        return false;
    });



});

</script>

@stop