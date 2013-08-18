@extends('layouts.dialog')


@section('content')

{{Former::vertical_open_for_files('companies/addoffice','POST',array('class'=>'vertical','id'=>'addOffice','name'=>'addOffice'))}}

<div class="row">
    <div class="span6">
        {{ Former::select('officeCategory','Category')->options(Config::get('se.office_categories')) }}
        {{ Former::text('location','Address') }}
        {{ Former::text('email','Email (Main)') }}
        {{ Former::text('phone','Phone') }}
        {{ Former::text('fax','Fax') }}
        {{ Former::hidden('companyId') }}

    </div>
    <div class="span6">
        {{ Former::select('country')->options(Config::get('country.countries'))->label('Country') }}
        {{ Former::select('city')->options(Config::get('city.cities'))->label('City') }}
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

    $('#addOffice').on('submit',function(){
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
            parent.$('#addOfficeModal').modal('hide');
        }else if(data.status == 'INVALID'){
            $('#notifier').html('Validation Failed').show();
        }else if(data.status == 'SAVEFAILED'){
            $('#notifier').html('Saving Failed').show();
        }

    }


});

</script>

@stop