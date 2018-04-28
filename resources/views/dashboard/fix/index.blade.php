@extends('layouts.appDashBoard')

@section('content')

    <div class="clearfix mb-2">
    	<h3 class="page-header">静的ページ一覧</h3>
		<a href="{{ url('/dashboard/fixes/create') }}" class="btn btn-success pull-right">新規追加</a>
    </div>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    {{ $fixes->links() }}
        
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>ID</th>
              <th class="col-md-4">タイトル</th>
              <th class="col-md-2">サブタイトル</th>
              <th class="col-md-2">スラッグ</th>
              <th class="col-md-1">ステータス</th>
              <th class="col-md-3">更新日</th>
              <th></th>
              <th></th>
              
            </tr>
          </thead>
          <tbody>
          
    	<?php //echo "SESSION: " . session('del_key'); ?>
        
    	@foreach($fixes as $obj)
        	<tr>
            	<td>
                	{{$obj->id}}
                </td>
                                    
                <td>
                	{{ $obj->title }}
                </td>

                <td>
                	{{ $obj->sub_title }}
                </td>

                <td>
                	{{ $obj->slug }}
                </td>

                <td>
                	@if($obj->not_open)
                    <span class="text-danger">非公開</span>
                    @else
                    <span class="text-success">公開中</span>
                    @endif
                </td>


                <td>
                	{{ $obj->updated_at }}
                </td>

                <td>
                	<a href="{{url('dashboard/fixes/'.$obj->id)}}" class="btn btn-primary btn-sm center-block">編集</a>
                </td>
                <td>
                	<form role="form" method="POST" action="{{ url('/dashboard/fixes/'.$obj->id) }}">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}

                	<input type="submit" class="btn btn-danger btn-sm center-block" value="削除">
                    </form>
                </td>
        	</tr>
        @endforeach
        
        </tbody>
        </table>
        </div>
    
    {{ $fixes->links() }}
        
@endsection

