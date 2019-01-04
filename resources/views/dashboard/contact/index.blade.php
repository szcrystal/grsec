@extends('layouts.appDashBoard')

@section('content')

	<div class="text-left">
        <h1 class="Title">お問い合わせ一覧</h1>
        <p class="Description"></p>
    </div>

	<div class="clearfix">
     	{{--   
    	<a href="{{ url('/dashboard/contacts/create') }}" class="btn btn-success pull-right">問合せカテゴリー追加</a>
      --}}   
    </div>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    {{ $contacts->links() }}
        
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered table-hover bg-white"{{-- id="dataTable"--}} width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>ID</th>
              <th>お問合せ日</th>
              <th>種別</th>
              <th>名前</th>
              <th>メルアド</th>
              <th>内容</th>
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
                	{{ $obj->name }}
                </td>

                <td>
                	<a href="mailto:{{ $obj->email }}">{{ $obj->email }}</a>
                </td>

                <td>
                	<?php 
//                    	$comment = trim($obj->comment);
//                        $comment = str_replace("\n", '', $comment);
                        //echo mb_strlen($obj->comment);  
                    ?>
                    
                    {{ Ctm::shortStr($obj->comment, 100) }}
                	
                </td>

                <td>
                	<a style="margin:auto;" href="{{url('dashboard/contacts/'.$obj->id)}}" class="btn btn-success btn-sm center-block">確認</a><br>
                    <small class="text-secondary ml-1">ID{{$obj->id}}</small>
                	{{--
                	<a style="margin:auto;" href="{{url('dashboard/contacts/'.$obj->id. '/edit')}}" class="btn btn-primary btn-sm center-block">確認</a>
                 	--}}   
                 	   
                </td>
                
                {{--
                <td>
                	
					<form role="form" method="POST" action="{{ url('/dashboard/contacts/'.$obj->id) }}">
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
    
    {{ $contacts->links() }}
        
@endsection

