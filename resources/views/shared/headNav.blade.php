
<header class="site-header clearfix">
	<!-- Branding Image -->
    <?php
        use App\User;
        use App\Fix;
//        use App\Setting;
        
//        $path = Request::path();
//        $path = explode('/', $path);        

		//This is For PC. 
        //Sp -> headNavSp.php
    ?>
    <div class="fixed-top">
    <div class="site-description {{ Ctm::isEnv('alpha') ? 'text-danger' : '' }}">
    	<p>植木買うならグリーンロケット：グリーンロケットは初めての植木、お庭づくりを全力で応援します。</p>
    </div>

	<div class="head-first clearfix">
        <h1 class="float-left">
            <a href="{{ url('/') }}">
            <img src="{{ url('images/logo-name.png') }}" alt="{{ config('app.name', 'グリーンロケット') }}">
            <img src="{{ url('images/logo-symbol.png') }}" alt="{{ config('app.name', 'グリーンロケット') }}-ロゴマーク">
            </a>
        </h1>
        <span class="aniv">10th Anniversary</span>
        
        <div class="head-navi">      
            <ul class="clearfix">
            	<li>
                	<?php $firstGuide = Fix::where('slug', 'first-guide')->first(); ?>
                    
                    @if(isset($firstGuide) && $firstGuide->open_status)
                		<a href="{{ url('first-guide') }}">初めての方へ</a>
                    @endif
                </li>

                @if(! Auth::check())
                    <li><a href="{{ url('login') }}">ログイン</a></li>
                @else
                	<li><a href="{{ url('mypage') }}">マイページ</a></li>
                    
                	<li><a href="{{ url('/logout') }}"
                                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                    ログアウト
                            </a>

                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                    </li>
                    
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
                
           </ul> 
        </div>
        
    </div>
    
    </div><!-- fix -->
    
    <div class="head-second-wrap">
        <div class="head-second clearfix">
            <p>初めての方も安心の植物全品6ヶ月枯れ保証！3ヶ月取り置き可能！</p>
            <div class="clearfix s-form">
                <form class="my-1 my-lg-0" role="form" method="GET" action="{{ url('search') }}">
                    {{-- csrf_field() --}}
     
                    <input type="search" class="form-control rounded-0" name="s" placeholder="何かお探しですか？">
                    <i class="fa fa-search btn-s"></i>
     
                </form>
            </div>
            
            <address class="float-right">
                <p>営業日：月〜金曜（土曜不定休）<br>定休日：日・祝日</p>
                <ul class="list-unstyled clearfix">
                	<li></li>
                    <li><i class="fal fa-envelope"></i> <a href="mailto:info@green-rocket.jp">info@green-rocket.jp</a></li>
                </ul>
            </address>
        </div>
    
    </div><!-- wrap -->
    
</header>


@if(Ctm::isAgent('sp'))
    @include('shared.navSp')
@else
    @include('shared.navPc')
@endif


