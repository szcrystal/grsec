
<nav class="main-navigation">

            <?php
                use App\Category;
                use App\CategorySecond;
                use App\Item;
                $cates = Category::all();
            ?>

			<div class="menu-dropdown-wrap">
				<div class="menu-dropdown main-navi">
    					
            <ul style="position: relative;" class="clearfix">
            
            @foreach($cates as $cate)
                <li class="">
                    <a href="{{ url('category/' . $cate->slug) }}">
                        {{ $cate->name }}<i class="fa fa-caret-down" aria-hidden="true"></i>
                    </a>
                    
                    <div style="display:none; position:absolute; width: 100%; height: 20em; left: 0; top: 6em; z-index: 9999;" class="bg-white border  drop-menu clearfix">
                    	
                        <div class="float-left clearfix">
                        	<div class="float-left">
                            <a href="{{ url('category/' . $cate->slug) }}">
                                {{ $cate->name }}
                            </a>
                            <p>{{ $cate->meta_description }}</p>
                            </div>
                        
                            <ul class="float-left">
                                <?php
                                    $cateSecs = CategorySecond::where('parent_id', $cate->id)->get();
                                ?>
                                @foreach($cateSecs as $cateSec)
                                    <li><a href="{{ url('category/'.$cate->slug.'/'.$cateSec->slug) }}">{{ $cateSec->name }}</a></li>
                                @endforeach                  
                            </ul>
                        </div>
                        
                        <div class="clearfix float-right">
                        	<?php
                        	$cateItems = Item::where('cate_id', $cate->id)->orderBy('created_at','desc')->get()->take(3);
                            ?>
                            
                            <div class="clearfix">
                            <h3>最新の商品</h3>
                            @foreach($cateItems as $cateItem)
                            	<div class="float-left">
                                <a href="{{ url('item/'.$cateItem->id) }}">
                                <img src="{{ Storage::url($cateItem->main_img) }}" width="170" height="170">
                                <b class="d-block">{{ $cateItem->title }}</b>
                                </a>
                                </div>
                            @endforeach
                            </div>
                        </div>
                    
                    </div>
                </li>
            @endforeach
             
            </ul>
            
            </div>
            </div>
            
            
            
            
            
            
            
            
             


</nav>

