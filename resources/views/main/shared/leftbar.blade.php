
<div id="left-bar">
    <div class="panel panel-default">

    <?php
    	//extract(Ctm::getLeftbar());
        use App\Category;
        use App\CategorySecond;
        use App\Tag;
    ?>

        <div class="panel-body">
            
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
                    $tagLeftRanks = Tag::where('view_count','>',0)->orderBy('view_count', 'desc')->take(20)->get();
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
            
            
            <?php
                extract(Ctm::getFixPage());
            ?>
            
            @if(count($fixOthers) > 0)
            <div>
                <h5>初めての方へ</h5>
  
                <ul class="no-list ml-1">
                	@foreach($fixOthers as $fixOther)
                        <li><a href="{{ url($fixOther->slug) }}">
                            @if($fixOther->sub_title != '')
                            <i class="fa fa-angle-right"></i> {{ $fixOther->sub_title }}
                            @else
                            <i class="fa fa-angle-right"></i> {{ $fixOther->title }}
                            @endif
                        </a></li>
                    @endforeach
                </ul>
            </div>
            @endif

        </div><!-- panel-body -->
    </div><!-- panel -->

</div>


