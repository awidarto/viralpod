<?php
    function sa($item){
        if(URL::to($item) == URL::full() ){
            return  'class="active"';
        }else{
            return '';
        }
    }
?>
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
