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
    <div class="head-navi float-right col-md-5 mt-5">
        <nav>

            <ul class="clearfix">
            	<li>
                    <i class="fa fa-search"></i>
                    <div style="display:block;" class="clear s-form">
                        <div class="float-left">
                            <form class="my-1 my-lg-0" role="form" method="GET" action="{{ url('search') }}">
                                {{-- csrf_field() --}}

                                <div class="">
                                    <input type="search" class="form-control" name="s" placeholder="Search...">
                                </div>
                                
                                <button class="btn btn-s float-left" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </form>
                        </div>

                        
                    </div>
                </li>
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


