<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ Config::get('site.name') }}</title>
    <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    {{ HTML::style('bootplus/css/bootplus.min.css') }}
    {{ HTML::style('bootplus/css/bootplus-responsive.min.css') }}
    {{ HTML::style('bootplus/css/font-awesome.min.css') }}

    {{ HTML::style('css/dataTables.bootstrap.css') }}

    {{ HTML::style('css/bootstrap-timepicker.css') }}

    {{ HTML::style('css/bootstrap-datetimepicker.min.css') }}

    {{ HTML::style('css/flick/jquery-ui-1.9.2.custom.min.css') }}




  <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
      <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
      <![endif]-->

      {{ HTML::style('css/dialog.css') }}
      {{ HTML::style('css/form.css') }}
      {{ HTML::style('css/gridtable.css') }}
      {{ HTML::style('css/select2.css') }}
      {{ HTML::style('css/jquery.tagsinput.css') }}

      {{ HTML::style('css/jquery-fileupload/css/jquery.fileupload-ui.css') }}

      {{ HTML::style('js/jquery.fineuploader-3.7.0/fineuploader-3.7.0.css') }}



      <!-- Fav and touch icons -->
      <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
      <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
      <link rel="shortcut icon" href="../assets/ico/favicon.png">

      {{ HTML::script('js/jquery-1.9.1.js')}}
      {{ HTML::script('js/jquery-ui-1.9.2.custom.min.js')}}


      {{ HTML::script('js/jquery.removeWhitespace.min.js')}}
      {{ HTML::script('js/jquery.collagePlus.min.js')}}
      {{ HTML::script('js/jquery.collageCaption.js')}}
      {{ HTML::script('js/jquery-datatables/jquery.datatables.min.js')}}
      {{ HTML::script('js/jquery-datatables/datatables.bootstrap.js')}}

      {{ HTML::script('js/jquery.tagsinput.js') }}
      {{ HTML::script('js/jquery.form.js') }}

      {{ HTML::script('js/bootstrap-timepicker.js') }}
      {{ HTML::script('js/bootstrap-datetimepicker.min.js') }}


      {{ HTML::script('js/select2.js') }}

      {{ HTML::script('js/jquery-fileupload/vendor/jquery.ui.widget.js') }}

      {{ HTML::script('js/js-load-image/load-image.min.js') }}

      {{ HTML::script('js/js-canvas-to-blob/canvas-to-blob.min.js') }}

      {{ HTML::script('js/jquery-fileupload/jquery.iframe-transport.js') }}

      {{ HTML::script('js/jquery-fileupload/jquery.fileupload.js') }}

      {{ HTML::script('js/jquery-fileupload/jquery.fileupload-process.js') }}
      {{ HTML::script('js/jquery-fileupload/jquery.fileupload-image.js') }}
      {{ HTML::script('js/jquery-fileupload/jquery.fileupload-audio.js') }}
      {{ HTML::script('js/jquery-fileupload/jquery.fileupload-video.js') }}
      {{ HTML::script('js/jquery-fileupload/jquery.fileupload-validate.js') }}

      <script type="text/javascript">
        base = '{{ URL::to('/') }}/';
      </script>


      {{ HTML::script('js/app.js')}}

</head>

<body>

    @yield('content')

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    {{ HTML::script('bootplus/js/bootstrap.min.js')}}

</body>
</html>