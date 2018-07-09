<?php
use App\Item;
use App\User;

?>


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

<div class="clearfix s-form">
            <form class="my-1 my-lg-0" role="form" method="GET" action="{{ url('search') }}">
                {{-- csrf_field() --}}

                <input type="search" class="float-right" name="s" placeholder="Search...">

            </form>
</div>



<div class="fade-black">
	<span class="nav-tgl"><i class="fas fa-times"></i></span>	
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
	<div class="navi-body">

        <ul class="clearfix">
           
            @foreach($cates as $cate)
                <li class="">
                    
                    {{--
                    <span>{!! str_replace('/', "<br>", $cate->link_name) !!} <i class="fa fa-caret-down" aria-hidden="true"></i></span>
                    --}}

                    <section class="drops clearfix">
                    	
                        <div class="clearfix">
                        	<h3><a href="{{ url('category/' . $cate->slug) }}">
                                    {{ $cate->name }} <i class="fas fa-angle-double-right"></i>
                                </a></h3>
                            <div class="">
                                
                                <p>{{ $cate->meta_description }}</p>
                                
                            </div>
                        
                            <ul class="">
                                <?php
                                    $cateSecs = CategorySecond::where('parent_id', $cate->id)->get();
                                ?>
                                @foreach($cateSecs as $cateSec)
                                    <li><a href="{{ url('category/'.$cate->slug.'/'.$cateSec->slug) }}">{{ $cateSec->name }} <i class="fas fa-angle-double-right"></i></a></li>
                                @endforeach                  
                            </ul>
                        </div>
                        
                        <div class="clearfix">
                            <?php
                            $cateItems = Item::where('cate_id', $cate->id)->orderBy('created_at','desc')->get()->take(3);
                            ?>

                            <h3>{{ $cate->name }}の最新の商品</h3>
                                @foreach($cateItems as $cateItem)
                                    <div class="float-left">
                                        <a href="{{ url('item/'.$cateItem->id) }}">
                                            <img src="{{ Storage::url($cateItem->main_img) }}">
                                            <b class="d-block">{{ $cateItem->title }}</b>
                                        </a>
                                    </div>
                                @endforeach
                        </div>

                    </section>
                </li>
            @endforeach
            
            <li class="">
                
                {{--    
                <span>ページ<i class="fa fa-caret-down" aria-hidden="true"></i></span>
                --}}    

                    <section class="drops clearfix">
                    	
                        <div class="float-left clearfix">
                        	<h3><a href="#">
                                    初めての方へ <i class="fas fa-angle-double-right"></i>
                                </a></h3>
                            <div class="float-left">
                                
                                <p>・・・</p>
                                
                            </div>
                        
                            <ul class="float-left"> 
                                <li><a href="{{ url('#') }}">・・ <i class="fas fa-angle-double-right"></i></a></li>
                                <li><a href="{{ url('#') }}">・・ <i class="fas fa-angle-double-right"></i></a></li>
                                                  
                            </ul>
                        </div>
                        
                        <div class="clearfix float-right">
                            
                            <h3></h3>
                                
                        </div>

                    </section>
                </li>


        </ul>
    
    </div>
    
    

</nav>


</div>

