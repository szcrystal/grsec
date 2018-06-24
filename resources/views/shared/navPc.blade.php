
<nav class="main-navigation">

            <?php
                use App\Category;
                use App\CategorySecond;
                $cates = Category::all();
            ?>

			<div class="menu-dropdown-wrap">
				<div class="menu-dropdown">
    					
                        <ul class="clear">
                        
                        @foreach($cates as $cate)
                            <li>
                            	<a href="{{ url('category/' . $cate->slug) }}">{{ $cate->name }}</a>
        						<ul>
              						<?php
                    					$cateSecs = CategorySecond::where('parent_id', $cate->id)->get();
                                    ?>
              						@foreach($cateSecs as $cateSec)
                    					<li><a href="{{ url('category/'.$cate->slug.'/'.$cateSec->slug) }}">{{ $cateSec->name }}</a></li>
                    				@endforeach                  
              					</ul>                                          
                            </li>
                        @endforeach
                         
                        </ul>
                </div>

					

            </div>


</nav>

