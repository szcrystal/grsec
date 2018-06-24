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

    <h1 class="float-left">
    	<a href="{{ url('/') }}">
        <img src="{{ url('images/logo-name.png') }}" alt="{{ config('app.name', 'グリーンロケット') }}">
    	</a>
    </h1>
    
    <div class="head-center">
    	<img src="{{ url('images/logo-symbol.png') }}" alt="{{ config('app.name', 'グリーンロケット') }}-logo">
    </div>
    
    <div class="head-navi">
        <div class="clearfix s-form">
            <form class="my-1 my-lg-0" role="form" method="GET" action="{{ url('search') }}">
                {{-- csrf_field() --}}
 
                <input type="search" class="form-control" name="s" placeholder="Search...">
 
            </form>
        </div>
            
            <ul class="clearfix">
            	<li><a href="#"><i class="fa fa-search btn-s"></i></a></li>
            	<li><a href="{{ url('shop/cart') }}"><i class="fas fa-shopping-basket"></i></a></li>
            	@if(! Auth::check())
                    <li><a href="{{ url('login') }}"><i class="fas fa-user"></i></a></li>
                @else
                	<li><a href="{{ url('mypage/favorite') }}"><i class="fas fa-heart"></i></a></li>
                	<li class="dropdown show">
                      <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user"></i></a>

                          <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="{{ url('mypage') }}">マイページ</a>
                            <a class="dropdown-item" href="{{ url('mypage/favorite') }}">お気に入り</a>
                            <a href="{{ url('/logout') }}" class="dropdown-item"
                                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                    ログアウト
                            </a>

                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                          </div>
                    </li>
                    
                @endif
                
                
           </ul> 
       
    </div>
    
</header>



</div>

@if(Ctm::isAgent('sp'))
    @include('shared.navSp')
@else
    @include('shared.navPc')
@endif


