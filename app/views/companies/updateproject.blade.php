@extends('layouts.dialog')


@section('content')

{{Former::vertical_open_for_files('companies/addproject','POST',array('class'=>'vertical','id'=>'addProject','name'=>'addProject'))}}

<div class="row">
    <div class="span6">
        {{ Former::text('projectName','Project Name') }}

        {{ Former::select('projectApplication[]')->options(Config::get('se.project_applications'))->multiple(true)->label('Project Application') }}

        {{ Former::hidden('companyId') }}

    </div>
    <div class="span6">

        {{ Former::text('productUsed','Product Used') }}

        <button class="btn btn-primary" id="btnAddProject">Save changes</button>
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

    $('#addProject').on('submit',function(){
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
            parent.$('#addProjectModal').modal('hide');
        }else if(data.status == 'INVALID'){
            $('#notifier').html('Validation Failed').show();
        }else if(data.status == 'SAVEFAILED'){
            $('#notifier').html('Saving Failed').show();
        }

    }


});

</script>

@stop