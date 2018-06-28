
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
                    
                    <span>ページ<i class="fa fa-caret-down" aria-hidden="true"></i></span>
                    

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

