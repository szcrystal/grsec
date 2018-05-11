@extends('layouts.appDashBoard')

@section('content')

    	
	{{-- @include('dbd_shared.search') --}}

    <h3 class="page-header">ユーザー一覧</h3>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    {{ $users->links() }}

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>ID</th>
              <th class="col-md-2">名前</th>
              <th class="col-md-3">メールアドレス</th>
              <th class="col-md-2">状態</th>
              <th class="col-md-2">登録日</th>
              <th></th>
              <th></th>
              <th></th>
            </tr>
          </thead>
          <tbody>
          
    	<?php //echo "SESSION: " . session('del_key'); ?>
        
    	@foreach($users as $obj)
        	<tr>
            	<td>
                	{{$obj->id}}
                </td>

				<td>
	        		<strong>{{$obj->name}}</strong>
                </td>
                                    
                <td>
                	{{ $obj->email }}
                </td>

                <td>
					@if($obj->active)
						有効
                    @else
						<span class="text-danger">無効</span>
                    @endif
                </td>

                <td>
                	{{ date('Y/m/d H:m', strtotime($obj->created_at)) }}
                </td>

                <td>
                	<a href="{{url('dashboard/users/'.$obj->id)}}" class="btn btn-primary btn-sm center-block">編集</a>
                </td>
                <td>
                	<a href="{{url('dashboard/userlogin/'.$obj->id)}}" class="btn btn-warning btn-sm center-block" target="_brank">Login</a>
                </td>
                <td>
                	@if($obj->id == 1)
                    	<span class="btn center-block">--</span>
                    @else
                    <form role="form" method="POST" action="{{ url('/dashboard/users/'.$obj->id) }}">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}

                	<input type="submit" class="btn btn-danger btn-sm center-block" value="削除">
                    </form>
                    @endif
                </td>
        	</tr>
        @endforeach
        
        </tbody>
        </table>
        </div>
    
    {{ $users->links() }}
        
@endsection

