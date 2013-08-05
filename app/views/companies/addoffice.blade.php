@extends('layouts.dialog')


@section('content')

{{Former::vertical_open_for_files('companies/addoffice','POST',array('class'=>'vertical'))}}

<div class="row">
    <div class="span6">

        {{ Former::select('officeCategory','Category')->options(Config::get('se.office_categories')) }}
        {{ Former::text('location','Address') }}
        {{ Former::text('email','Email (Main)') }}
        {{ Former::text('phone','Phone') }}
        {{ Former::text('fax','Fax') }}


    </div>
    <div class="span6">
        {{ Former::select('country')->options(Config::get('country.countries'))->label('Country') }}
        {{ Former::select('city')->options(Config::get('city.cities'))->label('City') }}
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

});

</script>

@stop