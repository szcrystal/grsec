@extends('layouts.appDashBoard')

@section('content')

    <h3 class="page-header">
	@if($editId)
    管理者編集
    @else
    管理者登録
    @endif
    </h3>

    	@if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Error!!</strong> 追加できません
                <ul class="mt-2">
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

        <div class="mt-5">
        	@if(isset($admin))
        		<h5 class="mb-3">{{ $admin->name }}さんの編集</h5>
            @endif

            <form class="form-horizontal" role="form" method="POST" action="/dashboard/register">
                {{ csrf_field() }}

                <input type="hidden" name="edit_id" value="{{$editId}}">

                <fieldset class="form-group">
                    <label for="name" class="control-label">管理者名</label>

                        <input id="name" type="text" class="form-control col-md-6{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ isset($admin) ? $admin->name : old('name') }}">

                        @if ($errors->has('name'))
                            <span class="help-block text-danger">
                                {{ $errors->first('name') }}
                            </span>
                        @endif

                </fieldset>

                <fieldset class="form-group">
                    <label for="email" class="control-label">メールアドレス</label>

                        <input id="email" type="email" class="form-control col-md-6{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ isset($admin) ? $admin->email : old('email') }}">

                        @if ($errors->has('email'))
                            <span class="help-block text-danger">
                                {{ $errors->first('email') }}
                            </span>
                        @endif

                </fieldset>

				@if(! $editId)
                    <fieldset class="form-group">
                        <label for="password" class="control-label">パスワード</label>

                            <input id="password" type="password" class="form-control col-md-6{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password">

                            @if ($errors->has('password'))
                                <span class="help-block text-danger">
                                    {{ $errors->first('password') }}
                                </span>
                            @endif
                    </fieldset>
                @endif
                
                
                <fieldset class="mt-1 mb-5 form-group">
                    <label>権限</label>
                    <select class="form-control col-md-6{{ $errors->has('permission') ? ' is-invalid' : '' }}" name="permission">
                        <?php
                            $authTypes = ['A：主管理者'=>1, 'B：内部管理者'=>5, 'C：サイトデザイン'=>10];
                            $disabled = isset($admin) && $admin->id == 1 ? 'disabled' : ''; 
                        ?>
                        
                        <option selected disabled>選択して下さい</option>
                        
                        @foreach($authTypes as $key => $authTypeNum)
                            <?php
                                $selected = '';
                                if(Ctm::isOld()) {
                                    if(old('permission') == $authTypeNum)
                                        $selected = ' selected';
                                }
                                else {
                                    if(isset($admin) && $admin->permission == $authTypeNum) {
                                        $selected = ' selected';
                                    }
                                }
                            ?>
                            
                            <option value="{{ $authTypeNum }}"{{ $selected }} {{ $disabled }}>{{ $key }}</option>
                        @endforeach
                    </select>
                    
                    @if ($errors->has('permission'))
                        <span class="help-block text-danger">
                            {{ $errors->first('permission') }}
                        </span>
                    @endif   
                </fieldset>


                <div class="form-group">
                    <div class="">
                        <button type="submit" class="btn btn-primary col-md-2">
                            登録
                        </button>
                    </div>
                </div>
            </form>

        </div>

		<div class="row mt-5">
        <div class="table-responsive col-md-10">
        <table class="table table-striped table-bordered bg-white">
          <thead>
            <tr>
              <th>ID</th>
              <th>管理者名</th>
              <th>メールアドレス</th>
              <th>権限</th>
              <th></th>
              <th></th>
            </tr>
          </thead>
          <tbody>
          
    	<?php //echo "SESSION: " . session('del_key'); ?>
        
    	@foreach($admins as $obj)
        	<tr>
            	<td>{{$obj->id}}</td>
                                    
                <td>
                	{{ $obj->name }}
                </td>

                <td>
                	{{ $obj->email }}
                </td>
                
                <td>
                	@if($obj->id == 2 && ! Ctm::isEnv('local'))
                    	--
                    @else
                        @if($obj->permission > 0 && $obj->permission < 5)
                            主管理者
                        @elseif($obj->permission > 4 && $obj->permission < 10)
                            内部管理者
                        @elseif($obj->permission > 9)
                            サイトデザイン
                        @else
                            <span class="text-danger">！未入力</span>
                        @endif
                    @endif
                </td>

                
                <td>
                	@if($obj->id == 2 && ! Ctm::isEnv('local'))
                    	--
                    @else
                		<a href="{{url('dashboard/register/'. $obj->id)}}" class="btn btn-success btn-sm center-block">編集</a>
                    @endif
                </td>
                
                
                <td>
                	@if(Auth::guard('admin')->id() < 3)
                        @if($obj->id > 2 && $obj->id != Auth::guard('admin')->id())
                            <form role="form" method="POST" action="{{ url('/dashboard/register/'.$obj->id) }}">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}

                                <input type="submit" class="btn btn-danger btn-sm center-block" value="削除">
                            </form>
                        @endif
                    @endif
                </td>

        	</tr>
        @endforeach
        
        </tbody>
        </table>
        </div>
        </div>
    
    {{ $admins->links() }}


@endsection
