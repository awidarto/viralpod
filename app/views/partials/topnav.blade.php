<div class="container top-nav">
    <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <div class="nav-collapse collapse">
        <ul class="nav">
            @if(Auth::check())            
                <li><a href="{{ URL::to('products') }}" class="active" >Products</a></li>
                <li><a href="{{ URL::to('projects') }}" class="active" >Projects</a></li>
                <li><a href="{{ URL::to('companies') }}" class="active" >Companies</a></li>
                <li><a href="{{ URL::to('events') }}" class="active" >Events</a></li>
                <li><a href="{{ URL::to('members') }}" class="active" >Members</a></li>
                <li><a href="{{ URL::to('administrators') }}" class="active" >Administrators</a></li>
            @endif
        </ul>
    </div><!--/.nav-collapse -->
</div>
