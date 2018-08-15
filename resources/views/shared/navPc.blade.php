
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
                            
                            <?php
                                use App\Fix;
                                use App\Setting;
                                
                                $set = Setting::get()->first();
                                
                                
                                $needIds = explode(',', $set->fix_need);
                                $otherIds = explode(',', $set->fix_other);
                                
                                $fixNeeds = Fix::whereIn('id', $needIds)->where('open_status', 1)->orderByRaw("FIELD(id, $set->fix_need)")->get();
                                $fixOthers = Fix::whereIn('id', $otherIds)->where('open_status', 1)->orderByRaw("FIELD(id, $set->fix_other)")->get();
                            ?>
                        
                        	@if($fixOthers) 
                            <ul class="float-left list-unstyled"> 
                                @foreach($fixOthers as $fixOther)
                                    <li><a href="{{ url($fixOther->slug) }}">
                                        @if($fixOther->sub_title != '')
                                        {{ $fixOther->sub_title }} <i class="fas fa-angle-double-right"></i>
                                        @else
                                        {{ $fixOther->title }} <i class="fas fa-angle-double-right"></i>
                                        @endif
                                    </a></li>
                                @endforeach                     
                            </ul>
                            @endif
                        </div>
                        
                        <div class="clearfix float-right pl-5">
                            
                            <h3>グリーンロケットについて</h3>
                            
                            <ul class="mt-3 list-unstyled">
                            @if($fixNeeds)         
                                @foreach($fixNeeds as $fixNeed)
                                <li><a href="{{ url($fixNeed->slug) }}">
                                    @if($fixNeed->sub_title != '')
                                    {{ $fixNeed->sub_title }} <i class="fas fa-angle-double-right"></i>
                                    @else
                                    {{ $fixNeed->title }} <i class="fas fa-angle-double-right"></i>
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

