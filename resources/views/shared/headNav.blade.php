<div class="fixed-top">

<header class="site-header clearfix">
	<!-- Branding Image -->
    <?php
//        use App\State;
//        use App\Setting;
        
        $path = Request::path();
        $path = explode('/', $path);
        

    ?>

    @if(Ctm::isAgent('sp'))
        <div id="menuButton" class="nav-tgl">
            <div>
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    @endif

    <h1 class="float-left mt-3 ml-2 col-md-3"><a class="navbar-brand" href="{{ url('/') }}">
        <img src="{{ url('images/logo-name.png') }}" alt="{{ config('app.name', 'GREEN ROCKET') }}">

    </a></h1>
    
    <div class="head-navi float-right col-md-8 mt-3">
        <nav>
            <ul class="clearfix">
                 <li><a href="#">初めての方へ</a>

                <li>ログイン</li>
                <li>新規登録</li>
                <li>
                	<i class="fa fa-search"></i>
                </li>
           </ul>         
        </nav>
    </div>

	<div style="display:none;" class="clear s-form">
		<div class="float-left">
            <form class="my-1 my-lg-0" role="form" method="GET" action="{{ url('search') }}">
                {{-- csrf_field() --}}

                <div class="">
                    <input type="search" class="form-control" name="s" placeholder="Search...">
                </div>
            </form>
        </div>

        <button class="btn btn-s float-left" type="submit">
            <i class="fa fa-search"></i>
        </button>
    </div>
    
    
</header>

</div>

@if(Ctm::isAgent('sp'))
    @include('shared.navSp')
@else
    @include('shared.navPc')
@endif


