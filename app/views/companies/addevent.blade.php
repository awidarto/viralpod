@extends('layouts.dialog')


@section('content')

{{Former::vertical_open_for_files('companies/addevent','POST',array('class'=>'vertical','id'=>'addEvent','name'=>'addEvent'))}}

<div class="row">
    <div class="span6">
        {{ Former::text('eventTitle','Event Title') }}

        {{ View::make('partials.editortoolbar')->render() }}
        {{ Former::textarea('eventDescription','Description')->id('description') }}
        {{ Former::text('eventOwner','Owner') }}
        {{ Former::text('visibleTags','Tags (visible)')->class('tag_keyword') }}
        {{ Former::text('hiddenTags','Tags (hidden)')->class('tag_keyword') }}

        {{ Former::hidden('companyId',$companyId) }}

    </div>
    <div class="span6">

        <div class="control-group">
            <label class="control-label" for="startDate">Start Date</label>
            <div class="controls">
                <div class="input-append datepicker" id="dp3" data-date="" data-date-format="dd-mm-yyyy">
                  <input class="span2" size="16" type="text" name="startDate" value="">
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


        <button class="btn btn-primary" id="btnAddOffice">Save changes</button>
        <div id="notifier" style="display:none;" ></div>
    </div>
</div>

{{Former::close()}}


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

    $('#name').keyup(function(){
        var title = $('#name').val();
        var slug = string_to_slug(title);
        $('#permalink').val(slug);
    });
    */

    $('#addEvent').on('submit',function(){
        $(this).ajaxSubmit(options);
        return false;
    });

// jquery form
    var options = {
        target:        '#notifier',   // target element(s) to be updated with server response
        beforeSubmit:  preSubmission,  // pre-submit callback
        success:       postSubmission,  // post-submit callback
        url: '{{ URL::to($ajaxpost) }}',
        dataType:  'json'
    };

    function preSubmission(formData, jqForm, options){
        var queryString = $.param(formData);
        $('#notifier').html('Processing...');
        return true;
    }

    // post-submit callback
    function postSubmission(responseObj, statusText, xhr, $form)  {
        var data = responseObj;

        if(data.status == 'OK'){
            $('#notifier').html('Data Saved Successfully');
            parent.$('#addEventModal').modal('hide');
        }else if(data.status == 'INVALID'){
            $('#notifier').html('Validation Failed').show();
        }else if(data.status == 'SAVEFAILED'){
            $('#notifier').html('Saving Failed').show();
        }

    }


});

</script>

@stop