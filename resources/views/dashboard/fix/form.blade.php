@extends('layouts.appDashBoard')

@section('content')
	
	<h3 class="page-header">
	@if(isset($edit))
    静的ページ編集
	@else
	静的ページ新規追加
    @endif
    </h3>

    <div class="bs-component clearfix">
        <div class="pull-left">
            <a href="{{ url('/dashboard/fixes') }}" class=""><i class="fa fa-angle-double-left" aria-hidden="true"></i>一覧へ戻る</a>
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


    <div class="well">
        <form class="form-horizontal" role="form" method="POST" action="/dashboard/fixes">
			@if(isset($edit))
                <input type="hidden" name="edit_id" value="{{$id}}">
            @endif

            {{ csrf_field() }}

            <div class="form-group">
                <div class="col-md-7 col-md-offset-2">
                    <div class="checkbox">
                    	<?php
                            if(count(old()))
                            	$checked = old('not_open') ? ' checked' : '';
                            else
                            	$checked = isset($fix) && $fix->not_open ? ' checked' : '';
                        ?>
                        <label>
                            <input type="checkbox" name="not_open" value="1"{{ $checked }}> 非公開にする
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                <label for="title" class="col-md-2 control-label">タイトル</label>

                <div class="col-md-10">
                    <input id="title" type="text" class="form-control" name="title" value="{{ isset($fix) && !count(old()) ? $fix->title : old('title') }}" required>

                    @if ($errors->has('title'))
                        <span class="help-block">
                            <strong>{{ $errors->first('title') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('sub_title') ? ' has-error' : '' }}">
                <label for="sub_title" class="col-md-2 control-label">サブタイトル<br>（リンク名）</label>

                <div class="col-md-10">
                    <input id="sub_title" type="text" class="form-control" name="sub_title" value="{{ isset($fix) && !count(old()) ? $fix->sub_title : old('sub_title') }}" required>

                    @if ($errors->has('sub_title'))
                        <span class="help-block">
                            <strong>{{ $errors->first('sub_title') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
                <label for="slug" class="col-md-2 control-label">スラッグ</label>

                <div class="col-md-10">
                    <input id="slug" type="text" class="form-control" name="slug" value="{{ isset($fix) && !count(old()) ? $fix->slug : old('slug') }}" required>

                    @if ($errors->has('slug'))
                        <span class="help-block">
                            <strong>{{ $errors->first('slug') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('contents') ? ' has-error' : '' }}">
                <label for="contents" class="col-md-2 control-label">コンテンツ</label>

                <div class="col-md-10">
                    <textarea id="contents" class="form-control" name="contents" rows="30">{{ isset($fix) && !count(old()) ? $fix->contents : old('contents') }}</textarea>

                    @if ($errors->has('contents'))
                        <span class="help-block">
                            <strong>{{ $errors->first('contents') }}</strong>
                        </span>
                    @endif
                </div>
            </div>


              <div class="form-group">
                <div class="col-md-4 col-md-offset-4">
                    <button type="submit" class="btn btn-primary center-block w-btn"><span class="octicon octicon-sync"></span>更　新</button>
                </div>
            </div>

        </form>

    </div>

    

@endsection
