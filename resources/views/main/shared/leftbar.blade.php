
<div id="left-bar">
    <div class="panel panel-default">

    <?php
    	//extract(Ctm::getLeftbar());
        use App\Category;
        use App\CategorySecond;
        use App\Tag;
    ?>

        <div class="panel-body">
            @if(Ctm::isAgent('sp'))
                <div>
                    <ul class="navbar-nav mr-auto">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li class="nav-link"><a href="{{ url('/login') }}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Login</a></li>
                            <li class="nav-link"><a href="{{ url('/register') }}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Register</a></li>
                        @else
                            <li class="dropdown nav-item">
                                <a href="#" class="nav-link dropdown-toggle" id="dropdown01" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu" aria-labelledby="dropdown01" role="menu">
                                    <a href="{{ url('/mypage') }}" class="dropdown-item"><i class="fa fa-angle-double-right" aria-hidden="true"></i> My Page</a>

                                    <a href="{{ url('/logout') }}" class="dropdown-item"
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        <i class="fa fa-angle-double-right" aria-hidden="true"></i> Logout
                                    </a>

                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </div>
                            </li>
                        @endif
                        <li class="nav-link"><a href="{{ url('/contact') }}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Contact</a></li>
                    </ul>
                </div>
            @endif

            <div>
                <h5>カテゴリー</h5>
                <ul class="no-list">
                <?php
                    $cates = Category::get();
                ?>
                @foreach($cates as $cate)
                    <?php $subcates = CategorySecond::where('parent_id', $cate->id)->get(); ?>
                    <li class="cate-list">
                        <i class="fa fa-circle" aria-hidden="true"></i>
                        <a href="{{url('/category/'. $cate->slug)}}">{{ $cate->link_name }}</a>
                        
                        <ul>
                            @foreach($subcates as $subcate)
                                <li>
                                    <a href="{{url('category/'. $cate->slug.'/'.$subcate->slug) }}">{{ $subcate->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach

                </ul>
            </div>

            <div>
                <h5>人気タグ</h5>
                <ul class="no-list">
                <?php 
                    $tagLeftRanks = Tag::where('view_count','>',0)->orderBy('view_count', 'desc')->take(10)->get();
                    //$tagLeftRanks = Tag::orderBy('id', 'desc')->take(10)->get(); 
                ?>
                @foreach($tagLeftRanks as $val)
                    <li class="rank-tag">
                        {{-- <i class="fas fa-hashtag text-small"></i> --}}
                        #<a href="{{url('tag/' . $val->slug)}}">{{$val->name}}</a>
                    </li>
                @endforeach

                </ul>
            </div>

            <div>
                <h5>売れ筋ランキング TOP10</h5>
                <ul class="side-rank no-list">
                <?php
                	use App\Item;
                	$n = 1;
                    
                    $items = Item::where('open_status', 1)->orderBy('sale_count', 'desc')->take(10)->get();
                ?>
                @foreach($items as $item)
                    <li class="clearfix">
                    	@if($n < 4)
                        <span class="rank-{{ $n }}">{{ $n }}</span>
                        @else
                        <span class="rank-n">{{ $n }}</span>
                        @endif
                        
                        <a href="{{url('item/'.$item->id)}}">
                        	{{ $item->title }}
                        </a>
                    </li>
                    <?php $n++; ?>
                @endforeach

                </ul>
            </div>
            
            <div>
                <h5>ページ</h5>
                <ul class="side-rank no-list">
                	<li>初めての方へ</li>

                </ul>
            </div>

        </div><!-- panel-body -->
    </div><!-- panel -->

</div>


