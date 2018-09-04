@extends('layouts.appDashBoard')

@section('content')

    	
	{{-- @include('dbd_shared.search') --}}

    <div class="clearfix">
    	<h3 class="page-header">親カテゴリー一覧</h3>
    </div>

    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    {{-- $cates->links() --}}
    
    
    <div class="row">
    <div class="col-md-12">
    <div class="mb-3">
        
        <div class="mb-3 text-right">
            <a href="{{url('dashboard/categories/create')}}" class="btn btn-info">新規追加</a>
        </div>
                           
            <div class="table-responsive">
                <table id="dataTable" class="table table-striped table-bordered table-hover bg-white" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>カテゴリー名</th>
                            <th>スラッグ</th>
                            <th>おすすめ</th>
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
                                
                                <td>
                                    @if($cate->is_top)
                                    	<span class="text-success">おすすめ</span><br>
                                    	{{ $cate->top_title }}
                                    @else
                                    	--
                                    @endif
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
                                    <a href="{{ url('dashboard/categories/'.$cate->id) }}" class="btn btn-success btn-sm center-block">編集</a>
                                </td>

                                <td>
                                    {{--
                                    <form role="form" method="POST" action="{{ url('/dashboard/categories/'.$cate->id) }}">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}

                                        <input type="submit" class="btn btn-danger btn-sm center-block" value="削除">
                                    </form>
                                    --}}
                                </td>
                            </tr>
                        @endforeach
                        
                    </tbody>
                </table>
            </div>

                </div>
            </div>
        </div>
        
    
    
    {{-- $cates->links() --}}
        
@endsection

