@extends('layouts.front')


@section('content')

<h3>{{$title}}</h3>

{{Former::open_for_files($submit,'POST',array('class'=>'custom addAttendeeForm'))}}

{{ Former::hidden('id')->value($formdata['_id']) }}
<div class="row">
    <div class="span6">

        {{ Former::select('mainCategory','Main Category')->options(Config::get('se.main_categories')) }}
        {{ Former::text('brandName','Brand Name') }}
        {{ Former::text('shopCategory','Shop Category') }}
        {{ Former::text('tradeName','Trade Name') }}
        {{ Former::select('countryOfOrigin')->options(Config::get('country.countries'))->label('Country of Origin') }}
        {{ Former::text('modelNo','Model No.') }}
        {{ Former::text('collectionName','Collection Name') }}
        {{ Former::textarea('ecoFriendly','Eco-friendly')->id('ecofriendly') }}
        {{ Former::text('designedBy','Designed by') }}
        {{ Former::text('madeBy','Made by') }}
        {{ Former::text('priceUSD','Price ($USD)') }}
        {{ Former::text('visibleTags','Tags (visible)')->class('tag_keyword') }}
        {{ Former::text('hiddenTags','Tags (hidden)')->class('tag_keyword') }}

        <div class="control-group">
            <label class="control-label" for="userfile">Upload Images</label>
            <div class="controls">
                <span class="btn btn-success fileinput-button">
                    <i class="icon-plus icon-white"></i>
                    <span>Add files...</span>
                    <!-- The file input field used as target for the file upload widget -->
                    <input id="fileupload" type="file" name="files[]" multiple>
                </span>
                <br />
                <br />
                <div id="progress" class="progress progress-success progress-striped">
                    <div class="bar"></div>
                </div>
                <br />
                <div id="files" class="files">
                    <ul>
                        <?php

                            if( isset($formdata['filename']) ){

                                $filename = $formdata['filename'];
                                $thumbnail_url = $formdata['thumbnail_url'];

                                $thumb = '<li><img src="%s"></li><br /><span class="img-title">%s</span>';

                                for($t = 0; $t < count($filename);$t++){
                                    printf($thumb,$thumbnail_url[$t],$filename[$t]);
                                }

                            }
                        ?>
                        <?php
                            $allin = Input::old();
                            $showold = false;

                            if( count($allin) > 0){
                                $showold = true;
                            }

                            if($showold && isset( $allin['thumbnail_url'])){

                                $filename = $allin['filename'];
                                $thumbnail_url = $allin['thumbnail_url'];

                                $thumb = '<li><img src="%s"></li><br /><span class="img-title">%s</span>';

                                for($t = 0; $t < count($filename);$t++){
                                    printf($thumb,$thumbnail_url[$t],$filename[$t]);
                                }

                            }
                        ?>
                    </ul>
                </div>
                <div id="uploadedform">
                    <?php

                        if(isset( $formdata['filename'] )){

                            $count = 0;
                            $upcount = count($formdata['filename']);

                            $upl = '';
                            for($u = 0; $u < $upcount; $u++){
                                $upl .= '<input type="hidden" name="delete_type[]" value="' . $formdata['delete_type'][$u] . '">';
                                $upl .= '<input type="hidden" name="delete_url[]" value="' . $formdata['delete_url'][$u] . '">';
                                $upl .= '<input type="hidden" name="filename[]" value="' . $formdata['filename'][$u]  . '">';
                                $upl .= '<input type="hidden" name="filesize[]" value="' . $formdata['filesize'][$u]  . '">';
                                $upl .= '<input type="hidden" name="temp_dir[]" value="' . $formdata['temp_dir'][$u]  . '">';
                                $upl .= '<input type="hidden" name="thumbnail_url[]" value="' . $formdata['thumbnail_url'][$u] . '">';
                                $upl .= '<input type="hidden" name="filetype[]" value="' . $formdata['filetype'][$u] . '">';
                                $upl .= '<input type="hidden" name="fileurl[]" value="' . $formdata['fileurl'][$u] . '">';
                            }

                            print $upl;
                        }

                    ?>
                    <?php

                        if($showold && isset( $allin['filename'] )){

                            $count = 0;
                            $upcount = count($allin['filename']);

                            $upl = '';
                            for($u = 0; $u < $upcount; $u++){
                                $upl .= '<input type="hidden" name="delete_type[]" value="' . $allin['delete_type'][$u] . '">';
                                $upl .= '<input type="hidden" name="delete_url[]" value="' . $allin['delete_url'][$u] . '">';
                                $upl .= '<input type="hidden" name="filename[]" value="' . $allin['filename'][$u]  . '">';
                                $upl .= '<input type="hidden" name="filesize[]" value="' . $allin['filesize'][$u]  . '">';
                                $upl .= '<input type="hidden" name="temp_dir[]" value="' . $allin['temp_dir'][$u]  . '">';
                                $upl .= '<input type="hidden" name="thumbnail_url[]" value="' . $allin['thumbnail_url'][$u] . '">';
                                $upl .= '<input type="hidden" name="filetype[]" value="' . $allin['filetype'][$u] . '">';
                                $upl .= '<input type="hidden" name="fileurl[]" value="' . $allin['fileurl'][$u] . '">';
                            }

                            print $upl;
                        }

                    ?>
                </div>
            </div>
        </div>


    </div>
    <div class="span6">
        {{ Former::text('productName','Product Name') }}
        {{ Former::textarea('productProperties','Properties') }}

        {{ Former::select('productApplication[]')->options(Config::get('se.applications'))->multiple(true)->label('Application')->select($formdata['productApplication'])}}
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

    var url = '{{ URL::to('upload') }}';
/*
    $('#fileupload').fileupload({
        url: url,
        dataType: 'json',
        autoUpload: false,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        maxFileSize: 15000000, // 5 MB
        // Enable image resizing, except for Android and Opera,
        // which actually support image resizing, but fail to
        // send Blob objects via XHR requests:
        disableImageResize: /Android(?!.*Chrome)|Opera/
            .test(window.navigator.userAgent),
        previewMaxWidth: 100,
        previewMaxHeight: 100,
        previewCrop: true
    }).on('fileuploadadd', function (e, data) {
        data.context = $('<div/>').appendTo('#files');
        $.each(data.files, function (index, file) {
            var node = $('<p/>')
                    .append($('<span/>').text(file.name));
            if (!index) {
                node
                    .append('<br>')
                    .append(uploadButton.clone(true).data(data));
            }
            node.appendTo(data.context);
        });
    }).on('fileuploadprocessalways', function (e, data) {
        var index = data.index,
            file = data.files[index],
            node = $(data.context.children()[index]);
        if (file.preview) {
            node
                .prepend('<br>')
                .prepend(file.preview);
        }
        if (file.error) {
            node
                .append('<br>')
                .append(file.error);
        }
        if (index + 1 === data.files.length) {
            data.context.find('button')
                .text('Upload')
                .prop('disabled', !!data.files.error);
        }
    }).on('fileuploadprogressall', function (e, data) {
        var progress = parseInt(data.loaded / data.total * 100, 10);
        $('#progress .bar').css(
            'width',
            progress + '%'
        );
    }).on('fileuploaddone', function (e, data) {
        $.each(data.result.files, function (index, file) {
            var link = $('<a>')
                .attr('target', '_blank')
                .prop('href', file.url);
            $(data.context.children()[index])
                .wrap(link);
        });
    }).on('fileuploadfail', function (e, data) {
        $.each(data.result.files, function (index, file) {
            var error = $('<span/>').text(file.error);
            $(data.context.children()[index])
                .append('<br>')
                .append(error);
        });
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
*/
    $('#fileupload').fileupload({
        url: url,
        dataType: 'json',
        done: function (e, data) {
            $('#progress .bar').css(
                'width',
                '0%'
            );

            $.each(data.result.files, function (index, file) {
                var thumb = '<li><img src="' + file.thumbnail_url + '" /><br /><span class="img-title">' + file.name + '</span></li>';
                $(thumb).appendTo('#files ul');

                var upl = '<input type="hidden" name="delete_type[]" value="' + file.delete_type + '">';
                upl += '<input type="hidden" name="delete_url[]" value="' + file.delete_url + '">';
                upl += '<input type="hidden" name="filename[]" value="' + file.name  + '">';
                upl += '<input type="hidden" name="filesize[]" value="' + file.size  + '">';
                upl += '<input type="hidden" name="temp_dir[]" value="' + file.temp_dir  + '">';
                upl += '<input type="hidden" name="thumbnail_url[]" value="' + file.thumbnail_url + '">';
                upl += '<input type="hidden" name="filetype[]" value="' + file.type + '">';
                upl += '<input type="hidden" name="fileurl[]" value="' + file.url + '">';

                $(upl).appendTo('#uploadedform');

            });
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .bar').css(
                'width',
                progress + '%'
            );
        }
    })
    .prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');

    $('select').select2({
      width : 'resolve'
    });


    $('#field_role').change(function(){
        //alert($('#field_role').val());
        // load default permission here
    });

    /*
    var editor = new wysihtml5.Editor('ecofriendly', { // id of textarea element
      toolbar:      'wysihtml5-toolbar', // id of toolbar element
      parserRules:  wysihtml5ParserRules // defined in parser rules set
    });
    */

    $('#name').keyup(function(){
        var title = $('#name').val();
        var slug = string_to_slug(title);
        $('#permalink').val(slug);
    });

    //$('#color_input').colorPicker();

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