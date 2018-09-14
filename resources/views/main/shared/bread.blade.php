<?php
use App\Category;
use App\CategorySecond;
?>

<div class="">

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    
    <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fas fa-home"></i></a></li>
    
    @if($type == 'single')
    	<?php $cate = Category::find($item->cate_id); ?>
    	<li class="breadcrumb-item">
    		<a href="{{ url('category/'. $cate->slug) }}">{{ $cate->name }}</a>
        </li>
        @if(isset($item->subcate_id))
        	<?php $subcate = CategorySecond::find($item->subcate_id); ?>
        	<li class="breadcrumb-item">
    			<a href="{{ url('category/'. $cate->slug.'/'. $subcate->slug) }}">{{ $subcate->name }}</a>
        	</li>
        @endif
    	<li class="breadcrumb-item active" aria-current="page">
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
    	<li class="breadcrumb-item active" aria-current="page">
        	マイページ
        </li>
    
    @else
    	<li class="breadcrumb-item active" aria-current="page">
        	{{ $title }}
        </li>
        
    @endif
    
    
    
  </ol>
</nav>

</div>
