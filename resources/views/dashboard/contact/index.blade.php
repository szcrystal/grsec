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

        
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered table-hover bg-white"{{-- id="dataTable"--}} width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>ID</th>
              <th>お問合せ日</th>
              <th style="min-width:3em;">希望方法／状況</th>
              <th style="min-width:3em;">種別</th>
              <th style="min-width:5em;">名前</th>
              <th>メルアド／TEL番</th>
              <th style="min-width:6em;">希望日／時間</th>
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
                	@if(isset($obj->is_ask_type))
                        @if($obj->is_ask_type == 1)
                            <span class="text-success">電話</span>
                        @elseif($obj->is_ask_type == 2)
                            <span class="text-primary">メール</span>
                        @else
                        	<span>--</span>
                        @endif
                        <br>
                        @if($obj->status)
                        	<span class="text-small">対応済<span>
                        @else
                        	<span class="text-small text-danger">未対応</span>
                        @endif
                    @else
                    	--
                    @endif
                </td>

				<td>
	        		{{$obj->ask_category}}
                </td>
                                    
                <td>
                	{{ $obj->name }}
                </td>

                <td>
                	<a href="mailto:{{ $obj->email }}">{{ $obj->email }}</a><br>
                    {{ $obj->tel_num }}
                </td>
                
                <td>
                	<span class="text-small">{{ $obj->request_day }}<br>{{ $obj->request_time }}</span>
                </td>

                <td>
                	<?php 
//                    	$comment = trim($obj->comment);
//                        $comment = str_replace("\n", '', $comment);
                        //echo mb_strlen($obj->comment);  
                    ?>
                    
                    <span class="text-small">{{ Ctm::shortStr($obj->comment, 100) }}</span>
                	
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

@endsection

