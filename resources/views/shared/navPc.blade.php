
<nav class="main-navigation">

            <?php
                use App\Category;

                
                $cates = Category::all();
            ?>



			<div class="menu-dropdown-wrap">
				<div class="menu-dropdown clear col-md-12">
    					
         				                           
                	
                        <ul class="clear">
                        {{--
                        @foreach($cates as $cate)
                            <li>
								<span class="rank-tag">
                            	<a href="{{ url('category/' . $cate->slug) }}">{{ $cate->name }}</a>
								</span>
                            </li>
                        @endforeach
                        --}}
                        	<li><a href="{{ url('transactions-law') }}">特定商取引法の表示</a></li>
                         	<li><a href="{{ url('company') }}">会社概要</a></li>   
                          	<li><a href="{{ url('about-delfee') }}">送料について</a>   
                        </ul>
                </div>

					

            </div>


</nav>

