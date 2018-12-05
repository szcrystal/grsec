@extends('layouts.appDashBoard')

@section('content')
	
	<div class="text-left">
        <h1 class="Title">
	@if(isset($edit))
    子カテゴリー編集
	@else
	子カテゴリー新規追加
    @endif
    </h1>
    <p class="Description"></p>
    </div>

    <div class="row">
      <div class="col-sm-12 col-md-6 col-lg-6 col-xl-5 mb-5">
        <div class="bs-component clearfix">
        <div class="pull-left">
            <a href="{{ url('/dashboard/categories/sub') }}" class="btn bg-white border border-1 border-secondary border-round text-primary"><i class="fa fa-angle-double-left" aria-hidden="true"></i>一覧へ戻る</a>
        </div>
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
        
    <div class="col-lg-12">
        <form class="form-horizontal" role="form" method="POST" action="/dashboard/categories/sub" enctype="multipart/form-data">
        	
            <div class="form-group mt-5">
                <button type="submit" class="btn btn-primary btn-block w-btn w-25 mx-auto">更　新</button>
        	</div>

            {{ csrf_field() }}
            
            @if(isset($edit))
                <input type="hidden" name="edit_id" value="{{$id}}">
            @endif
            
   
            <div class="form-group clearfix mb-4 thumb-wrap mt-5 pt-3">
            	<span class="text-small text-secondary d-block mb-3">＊UPする画像のファイル名は全て半角英数字とハイフンのみで構成して下さい。(abc-123.jpg など)</span>
                
                <fieldset class="w-25 float-right">
                    <div class="col-md-12 checkbox text-right px-0">
                        <label>
                            <?php
                                $checked = '';
                                if(Ctm::isOld()) {
                                    if(old('del_mainimg'))
                                        $checked = ' checked';
                                }
                                else {
                                    if(isset($subCate) && $subCate->del_mainimg) {
                                        $checked = ' checked';
                                    }
                                }
                            ?>

                            <input type="hidden" name="del_mainimg" value="0">
                            <input type="checkbox" name="del_mainimg" value="1"{{ $checked }}> この画像を削除
                        </label>
                    </div>
                </fieldset>
                
                <fieldset>
                    <div class="float-left col-md-4 px-0 thumb-prev">
                        @if(count(old()) > 0)
                            @if(old('main_img') != '' && old('main_img'))
                            <img src="{{ Storage::url(old('main_img')) }}" class="img-fluid">
                            @elseif(isset($subCate) && $subCate->main_img)
                            <img src="{{ Storage::url($subCate->main_img) }}" class="img-fluid">
                            @else
                            <span class="no-img">No Image</span>
                            @endif
                        @elseif(isset($subCate) && $subCate->main_img)
                        <img src="{{ Storage::url($subCate->main_img) }}" class="img-fluid">
                        @else
                        <span class="no-img">No Image</span>
                        @endif
                    </div>
                    

                    <div class="float-left col-md-8 pl-3 pr-0">
                        <fieldset class="form-group{{ $errors->has('main_img') ? ' is-invalid' : '' }}">
                            <label for="main_img">アーカイブ画像</label>
                            <input class="form-control-file thumb-file" id="main_img" type="file" name="main_img">
                        </fieldset>
                    
                        @if ($errors->has('main_img'))
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('main_img') }}</strong>
                            </span>
                        @endif
                        
                        <span class="text-small text-secondary">＊アーカイブ画像は必ず必要なものとなります。<br>削除後の未入力など注意して下さい。</span>
                    
                    </div>
                </fieldset>
                
                {{--
                <input class="form-control mt-3 col-md-12{{ $errors->has('main_caption') ? ' is-invalid' : '' }}" name="main_caption" value="{{ Ctm::isOld() ? old('main_caption') : (isset($item) ? $item->main_caption : '') }}" placeholder="メインキャプション">

                    @if ($errors->has('main_caption'))
                        <div class="text-danger">
                            <span class="fa fa-exclamation form-control-feedback"></span>
                            <span>{{ $errors->first('main_caption') }}</span>
                        </div>
                    @endif
                --}}
            </div>
            
            <hr class="mb-4">

            
            <fieldset class="mb-4 form-group">
                <label>親カテゴリー</label>
                <select class="form-control col-md-6{{ $errors->has('parent_id') ? ' is-invalid' : '' }}" name="parent_id">
                    <option disabled selected>選択して下さい</option>
                    @foreach($cates as $cate)
                        <?php
                            $selected = '';
                            if(Ctm::isOld()) {
                                if(old('parent_id') == $cate->id)
                                    $selected = ' selected';
                            }
                            else {
                                if(isset($subCate) && $subCate->parent_id == $cate->id) {
                                    $selected = ' selected';
                                }
                            }
                        ?>
                        <option value="{{ $cate->id }}"{{ $selected }}>{{ $cate->name }}</option>
                    @endforeach
                </select>
                
                @if ($errors->has('parent_id'))
                    <div class="help-block text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('parent_id') }}</span>
                    </div>
                @endif
                
            </fieldset>

            <fieldset class="form-group">
                <label for="name" class="control-label">子カテゴリー名</label>

                <input id="name" type="text" class="form-control col-md-10{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ Ctm::isOld() ? old('name') : (isset($subCate) ? $subCate->name : '') }}">

                @if ($errors->has('name'))
                <div class="text-danger">
                    <span class="fa fa-exclamation form-control-feedback"></span>
                    <span>{{ $errors->first('name') }}</span>
                </div>
                @endif
            </fieldset>


            <fieldset class="form-group">
                <label for="slug" class="control-label">スラッグ（半角英数字・ハイフンのみ）</label>

                <input id="slug" type="text" class="form-control col-md-10{{ $errors->has('slug') ? ' is-invalid' : '' }}" name="slug" value="{{ Ctm::isOld() ? old('slug') : (isset($subCate) ? $subCate->slug : '') }}">

                @if ($errors->has('slug'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('slug') }}</span>
                    </div>
                @endif
            </fieldset>
            
        
            
            <?php
                $obj = null;
                if(isset($subCate)) $obj = $subCate;
            ?>
            
            @include('dashboard.shared.topRecommend')
            
            <hr class="mb-5">
            
            @include('dashboard.shared.meta')
            
            @include('dashboard.shared.contents')

          <div class="form-group mt-5">
                <button type="submit" class="btn btn-primary btn-block w-btn w-25 mx-auto">更　新</button>
        </div>

        </form>

    </div>

@endsection
