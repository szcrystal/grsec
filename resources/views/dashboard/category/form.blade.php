@extends('layouts.appDashBoard')

@section('content')
	
	<div class="text-left">
        <h1 class="Title">
	@if(isset($edit))
    親カテゴリー編集
	@else
	親カテゴリー新規追加
    @endif
    </h1>
    <p class="Description"></p>
    </div>

    <div class="row">
      <div class="col-sm-12 col-md-6 col-lg-6 col-xl-5 mb-5">
        <div class="bs-component clearfix">
        <div class="float-left">
            <a href="{{ url('/dashboard/categories') }}" class="btn bg-white border border-1 border-secondary border-round text-primary"><i class="fa fa-angle-double-left" aria-hidden="true"></i>一覧へ戻る</a>
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
        <form class="form-horizontal" role="form" method="POST" action="/dashboard/categories" enctype="multipart/form-data">
        	
            <div class="form-group mt-5">
                <button type="submit" class="btn btn-primary btn-block w-btn w-25 mx-auto">更　新</button>
        	</div>

            {{ csrf_field() }}
            
            @if(isset($edit))
                <input type="hidden" name="edit_id" value="{{$id}}">
            @endif

            <fieldset class="form-group">
                <label for="name" class="control-label">カテゴリー名</label>

                    <input id="name" type="text" class="form-control col-md-10{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ Ctm::isOld() ? old('name') : (isset($cate) ? $cate->name : '') }}">

                @if ($errors->has('name'))
                <div class="text-danger">
                    <span class="fa fa-exclamation form-control-feedback"></span>
                    <span>{{ $errors->first('name') }}</span>
                </div>
                @endif
            </fieldset>
            
            <fieldset class="form-group">
                <label for="link_name" class="control-label">カテゴリーリンク名（メニュー用）</label>

                    <input id="link_name" type="text" class="form-control col-md-10{{ $errors->has('link_name') ? ' is-invalid' : '' }}" name="link_name" value="{{ Ctm::isOld() ? old('link_name') : (isset($cate) ? $cate->link_name : '') }}">

                @if ($errors->has('link_name'))
                <div class="text-danger">
                    <span class="fa fa-exclamation form-control-feedback"></span>
                    <span>{{ $errors->first('link_name') }}</span>
                </div>
                @endif
            </fieldset>


            <fieldset class="form-group">
                <label for="slug" class="control-label">スラッグ</label>

                    <input id="slug" type="text" class="form-control col-md-10{{ $errors->has('slug') ? ' is-invalid' : '' }}" name="slug" value="{{ Ctm::isOld() ? old('slug') : (isset($cate) ? $cate->slug : '') }}">

                @if ($errors->has('slug'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('slug') }}</span>
                    </div>
                @endif
            </fieldset>
            
            <?php
            	$obj = null;
            	if(isset($cate)) $obj = $cate;
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
