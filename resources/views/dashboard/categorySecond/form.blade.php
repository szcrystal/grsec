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
      <div class="col-sm-12 col-md-6 col-lg-6 col-xl-5 mb-4">
        <div class="bs-component clearfix">
            <div class="">
                <a href="{{ url('/dashboard/categories/sub') }}" class="btn bg-white border border-1 border-secondary border-round text-primary"><i class="fa fa-angle-double-left" aria-hidden="true"></i>一覧へ戻る</a>
            </div>
            
            @if(isset($edit))
                <div class="mt-3 pt-4 mb-2">
                    <a href="{{ url('/dashboard/upper/'. $id. '?type=subcate') }}" class="btn btn-success border-round text-white d-block float-left"><i class="fa fa-angle-double-left" aria-hidden="true"></i> 上部コンテンツを編集 </a>
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
        
    <div class="col-lg-12">
        <form class="form-horizontal" role="form" method="POST" action="/dashboard/categories/sub" enctype="multipart/form-data">
        	
            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary btn-block w-btn w-25 mx-auto">更　新</button>
        	</div>

            {{ csrf_field() }}
            
            @if(isset($edit))
                <input type="hidden" name="edit_id" value="{{$id}}">
            @endif
            
            
            <fieldset class="mt-5 mb-4 form-group">
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

                <input id="name" type="text" class="form-control col-md-12{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ Ctm::isOld() ? old('name') : (isset($subCate) ? $subCate->name : '') }}">

                @if ($errors->has('name'))
                <div class="text-danger">
                    <span class="fa fa-exclamation form-control-feedback"></span>
                    <span>{{ $errors->first('name') }}</span>
                </div>
                @endif
            </fieldset>


            <fieldset class="form-group">
                <label for="slug" class="control-label">スラッグ（半角英数字・ハイフンのみ）</label>

                <input id="slug" type="text" class="form-control col-md-12{{ $errors->has('slug') ? ' is-invalid' : '' }}" name="slug" value="{{ Ctm::isOld() ? old('slug') : (isset($subCate) ? $subCate->slug : '') }}">

                @if ($errors->has('slug'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('slug') }}</span>
                    </div>
                @endif
            </fieldset>
            
        	<hr class="mt-5">
            
            <?php
                $obj = null;
                if(isset($subCate)) $obj = $subCate;
            ?>
            
            @include('dashboard.shared.topRecommend')
            
            <hr class="mb-5">
            
            @include('dashboard.shared.meta')
            
            {{--
            @include('dashboard.shared.contents')
            --}}

          <div class="form-group mt-5">
                <button type="submit" class="btn btn-primary btn-block w-btn w-25 mx-auto">更　新</button>
        </div>

        </form>

    </div>

@endsection
