<?php
use App\Category;

?>

<div class="">

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i></a></li>
    @if($type == 'single')
    	<li class="breadcrumb-item active">
        	{{ $item->title }}
        </li>
    @elseif($type == 'category')
        <li class="breadcrumb-item active">
        	{{ $cate->name }}
        </li>
    @elseif($type == 'subcategory')
        <li class="breadcrumb-item">
        	<a href="{{ url('category/' .$cate->slug) }}">{{ $cate->name }}</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
            {{ $subcate->name }}
        </li>
        
    @elseif($type == 'tag')
    	<li class="breadcrumb-item active" aria-current="page">
        	タグ:{{ $tag->name }}
        </li>
    
    @elseif($type=='search')
       <li class="breadcrumb-item active" aria-current="page">検索結果</li>
        
    @elseif($type == 'user')
    	<li class="breadcrumb-item">
        	<a href="{{ url('mypage') }}">マイページ</a>
        </li>
    	<li class="breadcrumb-item active" aria-current="page">
        	タグ:{{ $tag->name }}
        </li>
        
    @endif
    
    
    
  </ol>
</nav>

</div>
