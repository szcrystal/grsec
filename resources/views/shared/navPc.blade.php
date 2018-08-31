
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
                    
                    <span>
                    @if(isset($cate->link_name))
                    	{{ $cate->link_name }}
                    @else
                    	{{ $cate->name }}
                    @endif
                    </span>
                    {{-- str_replace('/', "<br>", $cate->link_name) --}}
                    

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
            

             
            </ul>
            
            </div>

            
            
            
            
            
            
            
            
             


</nav>

