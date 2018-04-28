@extends('layouts.appDashBoard')

@section('content')

    	
	{{-- @include('dbd_shared.search') --}}

    <div class="clearfix">
    	<h3 class="page-header">カテゴリー一覧</h3>
    	<a href="{{ url('/dashboard/categories/create') }}" class="btn btn-success pull-right mb-3">新規追加</a>
    </div>

    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    {{ $cates->links() }}
    
    
    <section class="section">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-block">
                        <div class="card-title-block">
                            <!-- <h3 class="title"> Responsive simple </h3> -->
                        </div>
                        <section class="example">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th class="w-50">カテゴリー名</th>
                                            <th class="w-25">スラッグ</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	@foreach($cates as $cate)
                                            <tr>
                                                <td>
                                                    {{$cate->id}}
                                                </td>

                                                <td>
                                                    <strong>{{$cate->name}}</strong>
                                                </td>
                                                                    
                                                <td>
                                                    {{ $cate->slug }}
                                                </td>

                                                {{--
                                                <td>
                                                    @if($cate->open_status)
                                                    有効
                                                    @else
                                                    <span class="text-danger">無効</span>
                                                    @endif
                                                </td>
                                                --}}


                                                <td>
                                                    <a href="{{ url('dashboard/categories/'.$cate->id) }}" class="btn btn-primary btn-sm center-block">編集</a>
                                                </td>

                                                <td>
                                                    <form role="form" method="POST" action="{{ url('/dashboard/categories/'.$cate->id) }}">
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
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </section>
        
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>ID</th>
              <th class="col-md-3">名前</th>
              <th class="col-md-4">スラッグ</th>
              <th></th>
              <th></th>
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
	        		<strong>{{$cate->name}}</strong>
                </td>
                                    
                <td>
                	{{ $cate->slug }}
                </td>

                {{--
                <td>
                	@if($cate->open_status)
					有効
                    @else
					<span class="text-danger">無効</span>
                    @endif
                </td>
                --}}


                <td>
                	<a href="{{ url('dashboard/categories/'.$cate->id) }}" class="btn btn-primary btn-sm center-block">編集</a>
                </td>

                <td>
                	<form role="form" method="POST" action="{{ url('/dashboard/categories/'.$cate->id) }}">
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
    
    {{ $cates->links() }}
        
@endsection

