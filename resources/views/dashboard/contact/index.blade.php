@extends('layouts.appDashBoard')

@section('content')

	<div class="clearfix">
    	<h3 class="page-header">問合せ一覧</h3>
    	<a href="{{ url('/dashboard/contacts/create') }}" class="btn btn-success pull-right">問合せカテゴリー追加</a>
    </div>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    {{ $contacts->links() }}
        
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>ID</th>
              <th class="col-md-1">問合わせ日</th>
              <th class="col-md-2">カテゴリー</th>
              <th class="col-md-2">削除記事<br>ID/タイトル</th>
              <th class="col-md-2">名前</th>
              <th class="col-md-2">メール</th>
              <th class="col-md-2">テキスト</th>
              <th class="col-md-1">対応状況</th>
              <th></th>
              <th></th>
            </tr>
          </thead>
          <tbody>
          
    	<?php //echo "SESSION: " . session('del_key'); ?>
        
    	@foreach($contacts as $obj)
        	<tr>
            	<td>
                	{{$obj->id}}
                </td>

                <td>
                	{{ Ctm::changeDate($obj->created_at) }}
                </td>

				<td>
	        		{{$obj->ask_category}}
                </td>

                <td>
                	@if($obj->delete_id)
                    	<a href="{{ url('dashboard/articles/'.$contact->delete_id) }}">{{ $obj->delete_id }}</a><br>
						<a href="{{ url('dashboard/articles/'.$contact->delete_id) }}">{{ $atcl->find($obj->delete_id)->title }}</a>
                    @endif
                </td>
                                    
                <td>
                	{{ $obj->user_name }}
                </td>

                <td>
                	{{ $obj->user_email }}
                </td>

                <td>
                	@if(strlen($obj->context) > 100)
					{{ substr($obj->context, 0, 100) . "..." }}
                    @else
					{{ $obj->context }}
                    @endif
                </td>
                <td>
                	@if($obj->done_status)
					対応済
                    @else
					<span class="text-danger">未対応</span>
                    @endif
                </td>

                <td>
                	<a style="margin:auto;" href="{{url('dashboard/contacts/'.$obj->id. '/edit')}}" class="btn btn-primary btn-sm center-block">編集</a>
                </td>
                <td>
					<form role="form" method="POST" action="{{ url('/dashboard/contacts/'.$obj->id) }}">
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
    
    {{ $contacts->links() }}
        
@endsection

