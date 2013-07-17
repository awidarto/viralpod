@extends('layouts.front')


@section('content')

<h3>{{$title}}</h3>

{{Former::open_for_files($submit,'POST',array('class'=>'custom addAttendeeForm'))}}

{{ Former::hidden('id')->value($formdata['_id']) }}
<div class="row">
    <div class="span6">

        {{ Former::text('eventTitle','Event Title') }}

        {{ View::make('partials.editortoolbar')->render() }}
        {{ Former::textarea('eventDescription','Description')->id('description') }}
        {{ Former::text('eventOwner','Owner') }}
        {{ Former::text('visibleTags','Tags (visible)')->class('tag_keyword') }}
        {{ Former::text('hiddenTags','Tags (hidden)')->class('tag_keyword') }}

    </div>
    <div class="span6">
        <div class="control-group">
            <label class="control-label" for="startDate">Start Date</label>
            <div class="controls">
                <div class="input-append datepicker" id="dp3" data-date="" data-date-format="dd-mm-yyyy">
                  <input class="span2" size="16" type="text" name="startDate" value="{{ date('d/m/y',$formdata['startDate']->sec)}}">
                  <span class="add-on"><i class="icon-th"></i></span>
                </div>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="endDate">End Date</label>
            <div class="controls">
                <div class="input-append datepicker" id="dp3" data-date="" data-date-format="dd-mm-yyyy">
                  <input class="span2" size="16" type="text" name="endDate" value="">
                  <span class="add-on"><i class="icon-th"></i></span>
                </div>
            </div>
        </div>
        {{ Former::text('openingHours','Opening Hours') }}

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