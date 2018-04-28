@extends('layouts.appDashBoard')

@section('content')

	<h3 class="page-header">
	@if(isset($edit))
    タググループ情報編集
	@else
	タググループ新規追加
    @endif
    </h3>

    <div class="bs-component clearfix">
        <div class="pull-left">
            <a href="{{ url('/dashboard/taggroups') }}" class="btn-link"><i class="fa fa-angle-double-left" aria-hidden="true"></i>一覧へ戻る</a>
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
        <form class="form-horizontal" role="form" method="POST" action="/dashboard/taggroups">
			@if(isset($edit))
                <input type="hidden" name="edit_id" value="{{$id}}">
            @endif

            {{ csrf_field() }}

            <div class="form-group">
                <div class="col-md-6 col-md-offset-3">
                    <div class="checkbox">
                        <label>
                        	<?php
                            	$checked = '';
                                if(Ctm::isOld()) {
                                    if(old('open_status'))
                                        $checked = ' checked';
                                }
                                else {
                                    //isset($article) && $article->del_status
                                    if(isset($group) && $group->open_status)
                                        $checked = ' checked';
                                }                                
                            ?>
                            <input type="checkbox" name="open_status" value="1"{{ $checked }}> 有効にする
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="col-md-3 control-label">グループ名</label>

                <?php $value = (old('name') !== NULL) ? old('name') : (isset($group) ? $group->name : ''); ?>

                <div class="col-md-6">
                    <input id="name" type="text" class="form-control" name="name" value="{{ $value }}" required>

                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{-- $errors->first('name') --}}</strong>
                        </span>
                    @endif
                </div>
            </div>


            <div class="form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
                <label for="title" class="col-md-3 control-label">スラッグ</label>

                <?php $value = (old('slug') !== NULL) ? old('slug') : (isset($group) ? $group->slug : ''); ?>

                <div class="col-md-6">
                    <input id="title" type="text" class="form-control" name="slug" value="{{ $value }}" required>

                    @if ($errors->has('slug'))
                        <span class="help-block">
                            <strong>{{-- $errors->first('slug') --}}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-4 col-md-offset-3">
                    <button type="submit" class="btn btn-primary center-block w-btn">更　新</button>
                </div>
            </div>

        </form>
    </div>

@endsection
