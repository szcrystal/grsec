<?php
use App\Item;
use App\User;

//This is For SP. 
//PC -> headNav.php

?>


<div class="fixed-top">

{{--
<div class="telephone">
	<a href="tel:0299530030"><i class="fal fa-phone"></i> 電話をかける<span class="text-small">（月〜土 8:00〜17:00）</span></a>
</div>
--}}


<header class="site-header clearfix">

	<div class="logos clearfix">
        <h1>
            <a href="{{ url('/') }}">
                <img src="{{ url('images/logo-name.png') }}" alt="{{ config('app.name', 'グリーンロケット') }}">
                <img src="{{ url('images/logo-symbol.png') }}" alt="{{ config('app.name', 'グリーンロケット') }}-ロゴマーク">
            </a>
        </h1>
        
    </div>    
    
    <div class="nav-tgl">
    	<i class="fal fa-bars"></i>
	</div>
    
    <div class="s-tgl">
    	<i class="fal fa-search"></i>
	</div>

</header>


    
    <div class="s-form-wrap">
        <div class="clearfix s-form">
            <form class="my-1 my-lg-0" role="form" method="GET" action="{{ url('search') }}">
                {{-- csrf_field() --}}

                <input type="search" class="form-control rounded-0" name="s" value="{{ Request::has('s') ? Request::input('s') : '' }}" placeholder="何かお探しですか？">
                <button class="btn-s"><i class="fa fa-search"></i></button>
            </form>
        </div>
    </div>
    
    
    <div class="nav-sp-wrap">
    <nav>

        <?php
            use App\Category;
            use App\CategorySecond;
            $cates = Category::all();
        ?>
        
        <div class="nav-sp">
        	<p>グリーンロケットは初めての植木、お庭づくりを全力で応援します</p>
            
            <ul class="clearfix list-unstyled">
                <li class="has-child">
                    初めての方へ <i class="fal fa-caret-down" aria-hidden="true"></i>
                    
                    <?php
                        extract(Ctm::getFixPage());
                    ?>
                
                    @if(count($fixOthers) > 0) 
                    <ul class="list-unstyled nav-child"> 
                        @foreach($fixOthers as $fixOther)
                            <li><a href="{{ url($fixOther->slug) }}">
                                @if($fixOther->sub_title != '')
                                {{ $fixOther->sub_title }} <i class="fal fa-angle-double-right"></i>
                                @else
                                {{ $fixOther->title }} <i class="fal fa-angle-double-right"></i>
                                @endif
                            </a></li>
                        @endforeach                     
                    </ul>
                    @endif
                </li>
                
                <li class="has-child">
                    グリーンロケットについて <i class="fal fa-caret-down" aria-hidden="true"></i>
                    <ul class="list-unstyled nav-child">
                        
                        @if(count($fixNeeds) > 0)         
                            @foreach($fixNeeds as $fixNeed)
                            <li><a href="{{ url($fixNeed->slug) }}">
                                @if($fixNeed->sub_title != '')
                                {{ $fixNeed->sub_title }} <i class="fal fa-angle-double-right"></i>
                                @else
                                {{ $fixNeed->title }} <i class="fal fa-angle-double-right"></i>
                                @endif
                            </a></li>
                            @endforeach
                        @endif 
                        <li><a href="{{ url('contact') }}">お問い合わせ <i class="fal fa-angle-double-right"></i></a></li>
                    </ul>
                </li>

                @foreach($cates as $cate)
                    <li class="">
                        <a href="{{ url('category/' . $cate->slug) }}">
                            {{ $cate->name }} <i class="fal fa-angle-double-right"></i>
                        </a>
                    </li>
                @endforeach 
                
                @if(Auth::check())
                    <li>
                        <a href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                ログアウト <i class="fal fa-angle-double-right"></i>
                        </a>

                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                @endif

            </ul>
        </div>

    </nav>
    </div>


</div><!-- fixed-top -->



{{--
<div class="head-navi">
    <p class="aniv">初めてでも安心！全品6ヶ月枯れ保証！3ヶ月取置き可能！</p>
</div>
--}}


<div class="icon-belt">
    <ul class="clearfix">
    	<li><a href="{{ url('/') }}"><i class="fal fa-home"></i></a></li>

        @if(! Auth::check())
            <li><a href="{{ url('login') }}"><i class="fal fa-sign-in"></i></a></li>
            <li><a href="{{ url('favorite') }}"><i class="fal fa-heart"></i></a></li>
            
            <form id="for-favorite" action="" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        @else
            <li><a href="{{ url('mypage') }}"><i class="fal fa-user"></i></a></li>

            <li><a href="{{ url('mypage/favorite') }}"><i class="fal fa-heart"></i></a></li>
            
            {{--
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
            --}}
        @endif
        
        
        <li><a href="{{ url('shop/cart') }}"><i class="fal fa-shopping-cart"></i></a></li>
        <li><a href="{{ url('contact') }}"><i class="fal fa-envelope"></i></a></li>
        
        @if(Auth::check())
        	<li><a href="{{ url('/logout') }}"
                            onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                            <i class="fal fa-sign-out"></i>
                </a>

                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
        @endif
        
   </ul> 
</div>


