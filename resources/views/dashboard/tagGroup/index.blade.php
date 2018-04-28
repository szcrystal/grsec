@extends('layouts.appDashBoard')

@section('content')


    <div class="clearfix">
    <h3 class="page-header">タググループ一覧</h3>
    <a href="{{ url('/dashboard/taggroups/create') }}" class="btn btn-success pull-right">新規追加</a>
    </div>


    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif


    <div class="table-responsive">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>ID</th>
              <th class="col-md-3">グループ名</th>
              <th class="col-md-3">スラッグ</th>
              <th class="col-md-2">状態</th>
              <th class="col-md-2">作成日</th>
              <th class="col-md-1"></th>
            </tr>
          </thead>
          <tbody>
          
    	<?php //echo "SESSION: " . session('del_key'); ?>
        
    	@foreach($groups as $group)
        	<tr>
            	<td>
                	{{$group->id}}
                </td>

				<td>
	        		<strong>{{$group->name}}</strong>
                </td>
                                    
                <td>
                	{{ $group->slug }}
                </td>

                <td>
                	@if($group->open_status)
					有効
                    @else
					<span class="text-danger">無効</span>
                    @endif
                </td>

                <td>
                	{{ $group->created_at }}
                </td>

                <td>
                	<a href="{{url('dashboard/taggroups/'.$group->id)}}" class="btn btn-primary btn-sm center-block">編集</a>
                </td>

				{{--
                <td>
                	<form role="form" method="POST" action="{{ url('/dashboard/taggroups/'.$group->id) }}">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}

                	<input type="submit" class="btn btn-danger btn-sm center-block" value="削除">
                    </form>
                </td>
                --}}
        	</tr>
        @endforeach
        
        </tbody>
        </table>
        </div>
    
    {{-- $groups->links() --}}

@endsection

