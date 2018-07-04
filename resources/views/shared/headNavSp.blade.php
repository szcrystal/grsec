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

	<div id="menuButton" class="nav-tgl float-left">
        <div>
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>

		<div class="clearfix s-form">
            <form class="my-1 my-lg-0" role="form" method="GET" action="{{ url('search') }}">
                {{-- csrf_field() --}}
 
                <input type="search" class="" name="s" placeholder="Search...">
            </form>
            
            <span><i class="fa fa-search btn-s"></i></span>
        </div>
            
        

</header>


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

        <ul class="state-nav clear">
            <li class="dropdown nav-item">
                <span>ALL <i class="fa fa-caret-down" aria-hidden="true"></i></span>

                <div class="menu-dropdown-wrap">
                <div class="menu-dropdown clear" aria-labelledby="dropdown01" role="menu">
                    <div class="col-md-12">
                        <ul class="clear">
                            <li><a href="{{ url('/') }}" class="dropdown-item"><i class="fa fa-angle-double-right" aria-hidden="true"></i> TOP</a>
                            <li><a href="{{ url('all/model') }}" class="dropdown-item"><i class="fa fa-angle-double-right" aria-hidden="true"></i> モデル</a>
                        </ul>
                    </div>

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

</nav>


</div>


