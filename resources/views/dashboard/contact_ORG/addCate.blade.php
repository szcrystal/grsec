@extends('layouts.appDashBoard')

@section('content')

    	
	{{-- @include('dbd_shared.search') --}}


    <h3 class="page-header">問合せ：カテゴリー一覧</h3>

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

	<div class="row">
    <div class="table-responsive col-md-6">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th class="col-md-1">ID</th>
            	<th class="col-md-4">カテゴリー</th>
              <th class="col-md-3">追加日</th>

              <th class="col-md-1"></th>
              
            </tr>
          </thead>
          <tbody>
          
    	<?php //echo "SESSION: " . session('del_key'); ?>
        
    	@foreach($cates as $cate)
        	<tr>
            	<td>
                	{{$cate->id}}
                </td>

				<td>
	        		{{$cate->category}}
                </td>
                                    
                <td>
                	{{ date('Y/m/d H:i', strtotime($cate->created_at)) }}
                </td>

                <td>
                	<a style="margin:auto;" href="{{url('dashboard/contacts/cate/'.$cate->id)}}" class="btn btn-primary btn-sm center-block">編集</a>
                </td>
        	</tr>
        @endforeach
        
        </tbody>
        </table>
        </div>

		<div class="col-md-5 col-md-offset-1">
		<form class="form-horizontal" role="form" method="POST" action="/dashboard/contacts">

            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
                    <label for="category" class="col-md-10 text-left">問合せカテゴリー追加</label>
                    <div class="col-md-10">
                        <input id="category" type="text" class="form-control" name="category" value="{{ old('category') }}" required>

                        @if ($errors->has('category'))
                            <span class="help-block">
                                <strong>{{ $errors->first('category') }}</strong>
                            </span>
                        @endif
                    </div>
            </div>

            <div class="form-group">
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">追 加</button>
                </div>
            </div>
        </form>
        </div>
    
    <?php //echo $objs->render(); ?>
    </div>
@endsection

