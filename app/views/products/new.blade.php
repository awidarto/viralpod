@extends('layouts.front')


@section('content')

<h3>{{$title}}</h3>

{{Former::open_for_files($submit,'POST',array('class'=>'custom addAttendeeForm'))}}

<div class="row">
    <div class="span6">

        {{ Former::select('mainCategory','Main Category')->options(Config::get('se.main_categories')) }}
        {{ Former::text('brandName','Brand Name') }}
        {{ Former::text('shopCategory','Shop Category') }}
        {{ Former::text('tradeName','Trade Name') }}
        {{ Former::select('countryOfOrigin')->options(Config::get('country.countries'))->label('Country of Origin') }}
        {{ Former::text('modelNo','Model No.') }}
        {{ Former::text('collectionName','Collection Name') }}

        {{ View::make('partials.editortoolbar')->render() }}

        {{ Former::textarea('ecoFriendly','Eco-friendly') }}
        {{ Former::text('designedBy','Designed by') }}
        {{ Former::text('madeBy','Made by') }}
        {{ Former::text('priceUSD','Price ($USD)') }}
        {{ Former::text('visibleTags','Tags (visible)')->class('tag_keyword') }}
        {{ Former::text('hiddenTags','Tags (hidden)')->class('tag_keyword') }}

    </div>
    <div class="span6">
        {{ Former::text('productName','Product Name') }}
        {{ Former::textarea('productProperties','Properties') }}

        {{ Former::select('productApplication[]')->options(Config::get('se.applications'))->multiple(true)->label('Application') }}
        {{ Former::select('productSystem[]')->options(Config::get('se.systems'))->name('productSystem')->multiple(true)->label('System') }}
        {{ Former::select('productFunction[]')->options(Config::get('se.functions'))->name('productFunction')->multiple(true)->label('Function') }}


        {{ Former::select('productCategory','Category')->options(Config::get('se.product_categories')) }}
        {{ Former::textarea('availableColours','Avail. Colours') }}
        {{ Former::textarea('availableMaterialFinishes','Avail. Materials & Finishes') }}
        {{ Former::textarea('availableDimension','Avail. Dimensions (mm)') }}

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

    var editor = new wysihtml5.Editor('bodycopy', { // id of textarea element
      toolbar:      'wysihtml5-toolbar', // id of toolbar element
      parserRules:  wysihtml5ParserRules // defined in parser rules set
    });

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