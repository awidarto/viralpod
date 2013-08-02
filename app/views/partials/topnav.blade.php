<?php
    function sa($item){
        if(URL::to($item) == URL::full() ){
            return  'class="active"';
        }else{
            return '';
        }
    }
?>
<div class="container top-nav">
    <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <div class="nav-collapse collapse">
        <ul class="nav">
            @if(Auth::check())
                <li><a href="{{ URL::to('companies') }}" {{ sa('companies') }} >Companies</a></li>
                <li><a href="{{ URL::to('products') }}" {{ sa('products') }} >Products</a></li>
                <li><a href="{{ URL::to('projects') }}" {{ sa('projects') }} >Projects</a></li>
                <li><a href="{{ URL::to('events') }}" {{ sa('events') }} >Events</a></li>
                <li><a href="{{ URL::to('members') }}" {{ sa('members') }} >Members</a></li>
                <li><a href="{{ URL::to('administrators') }}" {{ sa('administrators') }} >Administrators</a></li>
            @endif
        </ul>
    </div><!--/.nav-collapse -->
</div>
