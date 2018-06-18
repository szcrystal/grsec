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
    
    @if(env('APP_ENV') != 'trial') 
    <div class="head-navi float-right col-md-4 mt-5">
    
    	<div class="clearfix s-form">
            <form class="my-1 my-lg-0" role="form" method="GET" action="{{ url('search') }}">
                {{-- csrf_field() --}}

                
                <input type="search" class="form-control w-75 float-left" name="s" placeholder="Search...">

                <button class="btn btn-s float-left" type="submit">
                    <i class="fa fa-search"></i>
                </button>
            </form>
        </div>
    
        <nav class="mt-2">

            <ul class="clearfix">
            	<li><a href="{{ url('shop/cart') }}">カートを見る</a></li>
            	@if(! Auth::check())
                <li><a href="{{ url('login') }}">LogIn</a></li>
                <li><a href="{{ url('register') }}">新規登録</a></li>
                @else
                <li><a href="{{ url('mypage') }}">マイページ</a></li>
                <li>
                	<a href="{{ url('/logout') }}" class=""
                                onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                                ログアウト
                    </a>

                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
                
                @endif
                
                
                
                
                
           </ul> 
       
        </nav>
    </div>
    @endif

	
    
    
</header>

</div>

@if(Ctm::isAgent('sp'))
    @include('shared.navSp')
@else
    @include('shared.navPc')
@endif


