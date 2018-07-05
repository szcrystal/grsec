<div class="fixed-top">
<header class="site-header clearfix">

	<div class="logos">
        <h1>
            <a href="{{ url('/') }}">
                <img src="{{ url('images/logo-name.png') }}" alt="{{ config('app.name', 'グリーンロケット') }}">
                <img src="{{ url('images/logo-symbol.png') }}" alt="{{ config('app.name', 'グリーンロケット') }}-ロゴマーク">
            </a>
        </h1>	
    </div>

	{{--
	<div id="menuButton" class="nav-tgl float-left"> 
        <div>
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    --}}
    
    
    <div class="nav-tgl">
    	<i class="fa fa-bars"></i>
	</div>


	<div class="head-navi">
        <div class="clearfix s-form">
            <form class="my-1 my-lg-0" role="form" method="GET" action="{{ url('search') }}">
                {{-- csrf_field() --}}
 
                <input type="search" class="" name="s" placeholder="Search...">
 
            </form>
        </div>
            
        <ul class="clearfix">
            <li><span><i class="fa fa-search btn-s"></i></span></li>
            <li><a href="{{ url('shop/cart') }}"><i class="fas fa-shopping-basket"></i></a></li>
            @if(! Auth::check())
                <li><a href="{{ url('login') }}"><i class="fas fa-user"></i></a></li>
            @else
                <li><a href="{{ url('mypage/favorite') }}"><i class="fas fa-heart"></i></a></li>
                <li class="dropdown show">
                  <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user"></i></a>

                      <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <span class="ml-3"><b>{{ User::find(Auth::id())->name }}</b> 様</span>
                        <a class="dropdown-item mt-1" href="{{ url('mypage') }}">マイページ <i class="fa fa-angle-right"></i></a>
                        <a class="dropdown-item mt-1" href="{{ url('mypage/history') }}">購入履歴 <i class="fa fa-angle-right"></i></a>
                        <a class="dropdown-item mt-1" href="{{ url('mypage/favorite') }}">お気に入り <i class="fa fa-angle-right"></i></a>
                        <a href="{{ url('/logout') }}" class="dropdown-item mt-1"
                                onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                                ログアウト <i class="fa fa-angle-right"></i>
                        </a>

                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                      </div>
                </li>
            @endif
            
            <li><a href="{{ url('contact') }}"><i class="fas fa-envelope"></i></a></li>
            
            
       </ul> 
       
    </div>


</header>

<div class="fade-black">
	<span class="nav-tgl">X</span>	
</div>

<nav class="navbar main-navigation">

        <?php
            use App\Category;
            use App\CategorySecond;
//            use App\State;
//            use App\FeatureCategory;
            
            //$states = State::all();
            $cates = Category::all();
            //$subCates = CategorySecond::all();
//            $fCates = FeatureCategory::where('status', 1)->get();
        ?>
	<div class="panel-body">
    
    	
    
        <ul class="state-nav clear">
            <li class="dropdown nav-item">

                <div class="menu-dropdown-wrap">
                <div class="menu-dropdown clear" aria-labelledby="dropdown01" role="menu">
                    

                    <div class="col-md-12 mt-4">
                        <h2>カテゴリー</h2>
                        <ul class="clear">
                        @foreach($cates as $cate)
                            <li>
                                <span class="rank-tag">
                                <a href="{{ url('all/' . $cate->slug) }}">{{ $cate->name }}</a>
                                </span>
                                
                                <ul>
                                	<?php
                                		$subCates = CategorySecond::where('parent_id', $cate->id)->get();
                                    ?>
                                    
                                	@foreach($subCates as $subCate)
                                    	<li><a href="">{{ $subCate->name }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                        </ul>
                    </div>

                    
                </div>
                </div>
            </li>
        </ul>
    
    </div>
    
    

</nav>


</div>


