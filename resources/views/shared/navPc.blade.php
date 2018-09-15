
<nav class="main-navigation">

    <?php
        use App\Category;
        use App\CategorySecond;
        use App\Item;
        $cates = Category::take(7)->get();
    ?>


    <div class="main-navi">
                
    <ul class="clearfix">
    
    @foreach($cates as $cate)
        <li class="">
            
            <a href="{{ url('category/' . $cate->slug) }}">
            @if(isset($cate->link_name))
                {{ $cate->link_name }}
            @else
                {{ $cate->name }}
            @endif
            </a>
            {{-- str_replace('/', "<br>", $cate->link_name) --}}
            
        </li>
    @endforeach

    </ul>
    
    </div>

</nav>

