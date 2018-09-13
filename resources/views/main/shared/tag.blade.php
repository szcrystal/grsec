<?php

use App\Tag;
use App\TagRelation;

    $tagIds = TagRelation::where('item_id', $item->id)->get()->map(function($obj){
        return $obj->tag_id;
    })->all();
	
    
    //Controller内でないと下記のダブルクオーテーションで囲むimplodeでないとダメ
    $strs = '"'. implode('","', $tagIds) .'"';

        
    if($num)
        $tags = Tag::whereIn('id', $tagIds)->orderByRaw("FIELD(id, $strs)")->take($num)->get();
    else
        $tags = Tag::whereIn('id', $tagIds)->orderByRaw("FIELD(id, $strs)")->get();
?>


@foreach($tags as $tag)
    <span class="rank-tag">
    {{-- <i class="fa fa-tag" aria-hidden="true"></i> --}}
    <a href="{{ url('tag/' . $tag->slug) }}">#{{ $tag->name }}</a>
    </span>
@endforeach
