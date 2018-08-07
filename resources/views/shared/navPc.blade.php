
<nav class="main-navigation">

            <?php
                use App\Category;
                use App\CategorySecond;
                use App\Item;
                $cates = Category::all();
            ?>


            <div class="main-navi">
    					
            <ul class="clearfix">
            
            @foreach($cates as $cate)
                <li class="">
                    
                    <span>{!! str_replace('/', "<br>", $cate->link_name) !!} <i class="fa fa-caret-down" aria-hidden="true"></i></span>
                    

                    <section class="drops clearfix">
                    	
                        <div class="float-left clearfix">
                        	<h3><a href="{{ url('category/' . $cate->slug) }}">
                                    {{ $cate->name }} <i class="fas fa-angle-double-right"></i>
                                </a></h3>
                            <div class="float-left">
                                
                                <p>{{ $cate->meta_description }}</p>
                                
                            </div>
                        
                            <ul class="float-left">
                                <?php
                                    $cateSecs = CategorySecond::where('parent_id', $cate->id)->get();
                                ?>
                                @foreach($cateSecs as $cateSec)
                                    <li><a href="{{ url('category/'.$cate->slug.'/'.$cateSec->slug) }}">{{ $cateSec->name }} <i class="fas fa-angle-double-right"></i></a></li>
                                @endforeach                  
                            </ul>
                        </div>
                        
                        <div class="clearfix float-right">
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
                    
                    <span>初めての方 <i class="fa fa-caret-down" aria-hidden="true"></i></span>

                    <section class="drops clearfix">
                    	
                        <div class="float-left clearfix">
                        	<h3><a href="#">
                                    <a href="{{ url('first-guide') }}">初めての方へ <i class="fas fa-angle-double-right"></i></a>
                                </a></h3>
                            <div class="float-left">  
                                <p>グリーンロケットは、初めての植木づくりを全力で応援します。</p>
                            </div>
                        
                            <ul class="float-left"> 
                                <li><a href="{{ url('first-guide') }}">初めての方へ <i class="fas fa-angle-double-right"></i></a>
                                <li><a href="{{ url('faq') }}">よくある質問 <i class="fas fa-angle-double-right"></i></a>
                                <li><a href="{{ url('about-ensure') }}">枯れ保証について <i class="fas fa-angle-double-right"></i></a>
                                <li><a href="{{ url('howto-uetuke') }}">植木の植え付け方 <i class="fas fa-angle-double-right"></i></a>
                                <li><a href="{{ url('howto-water') }}">水やりの仕方 <i class="fas fa-angle-double-right"></i></a>
                                <li><a href="{{ url('howto-select') }}">植木の選び方 <i class="fas fa-angle-double-right"></i></a>                      
                            </ul>
                        </div>
                        
                        <div class="clearfix float-right">
                            
                            <h3></h3>
                            
                            <?php
                                use App\Fix;  
                                $fixes = Fix::whereIn('id',[1,2])->where('open_status', 1)->orderBy('id', 'asc')->get();
                            ?>
                            
                            <ul class="mt-4">
                            @if($fixes)         
                                @foreach($fixes as $fix)
                                <li><a href="{{ url($fix->slug) }}">
                                    @if($fix->sub_title != '')
                                    {{ $fix->sub_title }} <i class="fas fa-angle-double-right"></i>
                                    @else
                                    {{ $fix->title }} <i class="fas fa-angle-double-right"></i>
                                    @endif
                                </a></li>
                                @endforeach
                            @endif 
                                <li><a href="{{ url('contact') }}">お問い合わせ <i class="fas fa-angle-double-right"></i></a></li>
                            </ul>
                                
                        </div>

                    </section>
                </li>
             
            </ul>
            
            </div>

            
            
            
            
            
            
            
            
             


</nav>

