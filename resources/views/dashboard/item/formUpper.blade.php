@extends('layouts.appDashBoard')

@section('content')

<?php 
    if($type == 'item') {
        $name = $orgObj->title;
        
        $indexUrl = url('/dashboard/items');
        $editUrl = url('/dashboard/items/'. $id);
    }
    elseif($type == 'cate') {
        $name = 'カテゴリー：' . $orgObj->name;
        $indexUrl = url('/dashboard/categories');
        $editUrl = url('/dashboard/categories/'. $id);
    }
    elseif($type == 'subcate') {
        $name = '子供カテゴリー：' . $orgObj->name;
        $indexUrl = url('/dashboard/categories/sub');
        $editUrl = url('/dashboard/categories/sub/'. $id);
    }
    elseif($type == 'tag') {
        $name = 'タグ：' . $orgObj->name;
        $indexUrl = url('/dashboard/tags');
        $editUrl = url('/dashboard/tags/'. $id);
    }
?>

	
	<div class="text-left">
        <h1 class="Title">
        @if(isset($edit))
        上部コンテンツ編集
        @else
        上部コンテンツ新規追加
        @endif
        </h1>
        <p class="Description"></p>
    </div>

    <div class="row">
      <div class="col-md-12 mb-5">
        <div class="bs-component clearfix">
        <div class="">
            <a href="{{ $indexUrl }}" class="btn bg-white border border-round border-secondary text-primary"><i class="fa fa-angle-double-left" aria-hidden="true"></i> 一覧へ戻る</a>
            <br>
            <a href="{{ $editUrl }}" class="btn bg-white border border-round border-secondary text-primary d-inline-block mt-2"><i class="fa fa-angle-double-left" aria-hidden="true"></i> 編集画面へ戻る</a>
        </div>
        
        @if(isset($edit))
        	@if($type=='item')
                <?php 
                    $linkId = $orgObj->is_potset ? $orgObj->pot_parent_id : $id;
                ?>
                
                <div class="mt-4 text-right">
                    <a href="{{ url('/item/'. $linkId) }}" class="btn btn-warning border border-1 border-round text-white" target="_brank">この商品のページを見る <i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
                </div>
            @endif
        @endif
        
    	</div>
    </div>
  </div>



    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Error!!</strong> 追加できません<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
        
	@if (session('status'))
        <div class="alert alert-success text-uppercase">
            {!! nl2br(session('status')) !!}
        </div>
    @endif
        
    <div class="col-lg-12 mb-5">
        <form class="form-horizontal" role="form" method="POST" action="/dashboard/upper" enctype="multipart/form-data">
        
        	<div class="form-group mb-0">
                <div class="clearfix mb-5">
                    <button type="submit" class="btn btn-primary btn-block mx-auto w-btn w-25">更　新</button>
                </div>
                
                @if(isset($orgObj))
                	
                	
                    <b class="text-big">[{{ $orgObj->id }}] {{ $name }}の上部コンテンツ</b>
                @endif
            </div>

            {{ csrf_field() }}
            

            <input type="hidden" name="edit_id" value="{{ $id }}">
            <input type="hidden" name="type" value="{{ $type }}">

			<div class="form-group">
                <div class="col-md-12 text-right mt-0">
                    <div class="checkbox">
                        <label>
                            <?php
                                $checked = '';
                                if(Ctm::isOld()) {
                                    if(old('open_status'))
                                        $checked = ' checked';
                                }
                                else {
                                    if(isset($itemUpper) && ! $itemUpper->open_status) {
                                        $checked = ' checked';
                                    }
                                }
                            ?>
                            <input type="checkbox" name="open_status" value="1"{{ $checked }}> この上部コンテンツを表示しない
                        </label>
                    </div>
                </div>
            </div>
        
        	{{-- 
            <span class="text-small text-secondary d-block mb-2">＊UPする画像のファイル名は全て半角英数字とハイフンのみで構成して下さい。(abc-123.jpg など)</span>
        	--}}
        
        <?php
//        $n = 0;
//        $block = 'a';
//        print_r($errors);
//        //print_r(old());
//        echo old('block.' .$block . '.' . $n . '.title');
//        exit;
        
        ?>
        
        
        	@foreach($relArr as $blockKey => $upperRel)
        
                <?php
                    $n=0;
                    $block = $blockKey;
                    
                    $bCount = $blockCount[$blockKey];
                    
//                    if($blockKey == 'a') {
//                        $retu = 1;
//                    }
//                    elseif($blockKey == 'b') {
//                        $retu = 2;
//                    }
//                    elseif($blockKey == 'c') {
//                        $retu = 3;
//                    }
                ?>
                
                <hr class="mt-5">
        		<h4 class="mt-5 mb-3 p-2 bg-secondary text-light text-uppercase">{{ $blockKey }}ブロック（{{ $n+1 }}列部分）</h4>
                
                <fieldset class="mt-2 mb-5 form-group{{ $errors->has('block.' .$n) ? ' is-invalid' : '' }}">
                    <label class="text-uppercase">大タイトル（{{ $blockKey }}ブロック）</label>
                    
                    <input class="form-control col-md-12{{ $errors->has('block.' .$n) ? ' is-invalid' : '' }}" name="block[{{ $block }}][section][title]" value="{{ Ctm::isOld() ? old('title'.$n) : (isset($upperRel['section']) ? $upperRel['section']->title : '') }}" placeholder="">

                        @if ($errors->has('block.' .$n))
                            <div class="text-danger">
                                <span class="fa fa-exclamation form-control-feedback"></span>
                                <span>{{ $errors->first('block.' .$n) }}</span>
                            </div>
                        @endif
                </fieldset>

                <input type="hidden" name="block[{{ $block }}][section][rel_id]" value="{{ isset($upperRel['section']) ? $upperRel['section']->id : 0 }}">
                
            	@while($n < $bCount)
        			
                    <div class="border border-gray p-3  mb-3 bg-gray rounded">
                    @include('dashboard.shared.upperContents')
                    </div>

                    <?php $n++; ?>
                @endwhile
                
                <div class="form-group mt-5 pt-3">
                	<button type="submit" class="btn btn-primary btn-block w-btn w-25 mx-auto">更　新</button>
            	</div>
            
            @endforeach
        
        
        
        </form>

    </div>

    

@endsection
