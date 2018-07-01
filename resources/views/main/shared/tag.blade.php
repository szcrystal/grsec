<?php
use App\Tag;
use App\TagRelation;

    $tagIds = TagRelation::where('item_id',$item->id)->get()->map(function($obj){
        return $obj->tag_id;
    })->all();
    
    $tags = Tag::whereIn('id',$tagIds)->orderBy('id','asc')->get()->take($num);
?>


@foreach($tags as $tag)
    <span class="rank-tag">
    {{-- <i class="fa fa-tag" aria-hidden="true"></i> --}}
    <a href="{{ url('tag/' . $tag->slug) }}">#{{ $tag->name }}</a>
    </span>
@endforeach
