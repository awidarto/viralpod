<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">

    <title>{{ Config::get('site.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
      <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="description" content="">
      <meta name="author" content="">

      <!-- Le styles -->
      <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,700' rel='stylesheet' type='text/css'>

    <!-- Bootplus -->
    {{ HTML::style('bootplus/css/bootplus.min.css') }}
    {{ HTML::style('bootplus/css/bootplus-responsive.min.css') }}
    {{ HTML::style('bootplus/css/font-awesome.min.css') }}

    {{ HTML::style('css/dataTables.bootstrap.css') }}

    {{ HTML::style('css/bootstrap-timepicker.css') }}

    {{ HTML::style('css/bootstrap-modal.css') }}

    {{ HTML::style('css/bootstrap-datetimepicker.min.css') }}

    {{ HTML::style('css/flick/jquery-ui-1.9.2.custom.min.css') }}

    {{ HTML::style('css/summernote.css') }}

    <!--[if IE 7]>
        {{ HTML::style('bootplus/css/bootplus-ie7.min.css') }}
    <![endif]-->

      <style type="text/css">
      html,
      body {
        height: 100%;
        /* The html and body elements cannot have any padding or margin. */
      }

      /* Wrapper for page content to push down footer */
      #wrap {
        min-height: 100%;
        height: auto !important;
        height: 100%;
        /* Negative indent footer by it's height */
        margin: 0 auto -60px;
      }

      /* Set the fixed height of the footer here */
      #push,
      footer {
        height: 60px;
      }
      footer {
        background-color: #f5f5f5;
      }

      /* Lastly, apply responsive CSS fixes as necessary */
      @media (max-width: 767px) {
        footer {
          margin-left: -20px;
          margin-right: -20px;
          padding-left: 20px;
          padding-right: 20px;
        }
      }

      /*
      body {
        padding-top: 46px;
        padding-bottom: 40px;
      }
      */
       .hero-unit {
          background: #00001C url(../assets/img/cover4.jpg) no-repeat top left;
       }
       .hero-unit h1 {color: #FFF}
       .hero-unit p {color: #F5F5F5}
      </style>
      {{ HTML::style('bootplus/css/bootplus-responsive.min.css') }}

      <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
      <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
      <![endif]-->

      <!-- Fav and touch icons -->
      <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="../assets/ico/favicon.png">
  </head>

  <body>

      <div class="navbar navbar-fixed-top">
         <div class="navbar-inner">
           <div class="container">
             <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
             </button>
             <a class="brand" href="#">VRAL</a>
             <div class="nav-collapse collapse">
                @include('partials.topnav')

                <form class="navbar-form pull-right">
                    @if(Auth::check())
                        Hello {{ Auth::user()->fullname }}
                        <a href="#" >Settings</a>
                        <a href="{{ URL::to('logout')}}" >Logout</a>
                    @else
                        <input class="span2" type="text" placeholder="Email">
                        <input class="span2" type="password" placeholder="Password">
                        <button type="submit" class="btn btn-primary">Sign in</button>
                    @endif
                </form>

             </div><!--/.nav-collapse -->
           </div>
         </div>
       </div>


      <div class="container">

        @yield('content')

        <div id="push"></div>
      </div> <!-- /container -->

      <footer>
        <p>&copy; {{ Config::get('site.name')}} {{ date('Y',time()) }}</p>
      </footer>

      <!-- Le javascript
      ================================================== -->
      <!-- Placed at the end of the document so the pages load faster -->
      <script src="http://code.jquery.com/jquery.js"></script>
      {{ HTML::script('bootplus/js/bootstrap.min.js')}}

   </body>
</html>
