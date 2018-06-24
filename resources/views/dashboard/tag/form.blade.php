@extends('layouts.appDashBoard')

@section('content')
	
	<div class="text-left">
        <h1 class="Title">
	@if(isset($edit))
    タグ情報編集
	@else
	タグ新規追加
    @endif
    </h1>
    <p class="Description"></p>
    </div>

    <div class="row">
      <div class="col-sm-12 col-md-6 col-lg-6 col-xl-5 mb-5">
        <div class="bs-component clearfix">
        <div class="pull-left">
            <a href="{{ url('/dashboard/tags') }}" class="btn bg-white border border-secondary border-round text-primary"><i class="fa fa-angle-double-left" aria-hidden="true"></i>一覧へ戻る</a>
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
        <form class="form-horizontal" role="form" method="POST" action="/dashboard/tags" enctype="multipart/form-data">
			
            {{ csrf_field() }}
            
            @if(isset($edit))
                <input type="hidden" name="edit_id" value="{{$tagId}}">
            @endif


            <fieldset class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="control-label">タグ名</label>

                <div class="">
                    <input id="name" type="text" class="form-control col-md-10" name="name" value="{{ Ctm::isOld() ? old('name') : (isset($tag) ? $tag->name : '') }}">

                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
            </fieldset>


            <fieldset class="form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
                <label for="slug" class="control-label">スラッグ</label>

                <div class="">
                    <input id="slug" type="text" class="form-control col-md-10" name="slug" value="{{ Ctm::isOld() ? old('slug') : (isset($tag) ? $tag->slug : '') }}">

                    @if ($errors->has('slug'))
                        <span class="help-block">
                            <strong>{{ $errors->first('slug') }}</strong>
                        </span>
                    @endif
                </div>
            </fieldset>
            
            <?php
                $obj = null;
                if(isset($tag)) $obj = $tag;
            ?>
            
            @include('dashboard.shared.meta')
            
            @include('dashboard.shared.contents')


          <div class="form-group mt-5">
            <div class="">
                <button type="submit" class="btn btn-primary btn-block w-btn w-25 mx-auto">更　新</button>
            </div>
        </div>

        </form>

    </div>

@endsection
