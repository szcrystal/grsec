@extends('layouts.appDashBoard')

@section('content')
	
	<div class="text-left">
        <h1 class="Title">
        @if(isset($edit))
        上部コンテンツ編集&nbsp;&nbsp;<span>ID：{{ $id }}</span>
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
            <a href="{{ url('/dashboard/items') }}" class="btn bg-white border border-1 border-round border-secondary text-primary"><i class="fa fa-angle-double-left" aria-hidden="true"></i>一覧へ戻る</a><br>
            <a href="{{ url('/dashboard/items/'. $id) }}" class="btn bg-white border border-1 border-round border-secondary text-primary"><i class="fa fa-angle-double-left" aria-hidden="true"></i>商品編集へ戻る</a>
        </div>
        
        @if(isset($edit))
        	<?php $linkId = $item->is_potset ? $item->pot_parent_id : $id; ?>
            <div class="mt-4 text-right">
                <a href="{{ url('/item/'. $linkId) }}" class="btn btn-warning border border-1 border-round text-white" target="_brank">この商品のページを見る <i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
            </div>
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
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
        
    <div class="col-lg-12 mb-5">
        <form class="form-horizontal" role="form" method="POST" action="/dashboard/items" enctype="multipart/form-data">
        
        	<div class="form-group mb-0">
                <div class="clearfix mb-3">
                    <button type="submit" class="btn btn-primary btn-block mx-auto w-btn w-25">更　新</button>
                </div>
                
                @if(isset($item))
                	<b class="text-big">ID:{{ $item->id }} {{ $item->title }}の上部コンテンツ</b>
                @endif
            </div>

            {{ csrf_field() }}
            
            @if(isset($edit))
                <input type="hidden" name="edit_id" value="{{ $id }}">
            @endif

			<div class="form-group">
                <div class="col-md-12 text-right mb-3 pb-3 mt-0">
                    <div class="checkbox">
                        <label>
                            <?php
                                $checked = '';
                                if(Ctm::isOld()) {
                                    if(old('open_status'))
                                        $checked = ' checked';
                                }
                                else {
                                    if(isset($item) && ! $item->open_status) {
                                        $checked = ' checked';
                                    }
                                }
                            ?>
                            <input type="checkbox" name="open_status" value="1"{{ $checked }}> この上部コンテンツを表示しない
                        </label>
                    </div>
                </div>
            </div>
        
        <span class="text-small text-secondary d-block mb-3">＊UPする画像のファイル名は全て半角英数字とハイフンのみで構成して下さい。(abc-123.jpg など)</span>
        <hr>
        <h4 class="my-5 p-2 bg-secondary text-light">Aブロック（1列部分）</h4>
        
		
        <?php
            $n=0;
            $block = 'a';
        ?>
        
        @while($n < $blockACount)
        	
            @include('dashboard.shared.upperContents')

            <input type="hidden" name="block_a_count[]" value="{{ $n }}">
            
            <?php $n++; ?>
        @endwhile
        
        <div class="form-group mb-5 mr-3">
            <div class="clearfix">
                <button type="submit" class="btn btn-primary btn-block mx-auto w-btn w-25 float-right">更　新</button>
            </div>
        </div>
        
        <hr class="mt-5">
        <h4 class="my-5 p-2 bg-secondary text-light">Bブロック（2列部分）</h4>
        
        <?php
            $n=0;
            $block = 'b';
        ?>
        
        @while($n < $blockBCount)
        	
            @include('dashboard.shared.upperContents')

            <input type="hidden" name="block_b_count[]" value="{{ $n }}">
            
            <?php $n++; ?>
        @endwhile
        
        <div class="form-group mb-5 mr-3">
            <div class="clearfix">
                <button type="submit" class="btn btn-primary btn-block mx-auto w-btn w-25 float-right">更　新</button>
            </div>
        </div>
        
        <hr class="mt-5">
        <h4 class="my-5 p-2 bg-secondary text-light">Cブロック（3列部分）</h4>
        <?php
            $n=0;
            $block = 'c';
        ?>
        
        @while($n < $blockCCount)
        	
            @include('dashboard.shared.upperContents')

            <input type="hidden" name="block_c_count[]" value="{{ $n }}">
            
            <?php $n++; ?>
        @endwhile
        



     
  		
            
            
        
			
            
            
            
            
            
            
            
            
            
            

            
            
            
            <div class="form-group mt-5 pt-3">
                <button type="submit" class="btn btn-primary btn-block w-btn w-25 mx-auto">更　新</button>
            </div>
            

        </form>

    </div>

    

@endsection
