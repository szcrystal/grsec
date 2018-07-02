@extends('layouts.appDashBoard')

@section('content')

	<div class="text-left">
        <h1 class="Title">タグ一覧</h1>
        <p class="Description"></p>
    </div>


    <div class="row">


    </div>
    <!-- /.row -->
    

    {{ $tags->links() }}
    
      
    <div class="mb-3 text-right">
        <a href="{{url('dashboard/tags/create')}}" class="btn btn-info">新規追加</a>
    </div>
    
    
	<div class="">
        <div class="table-responsive">
        	<table id="dataTable" class="table table-striped table-bordered table-hover bg-white"{{-- id="dataTable"--}} width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>タグ名</th>
                        <th>スラッグ</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tags as $tag)
                        <tr>
                            <td>
                                {{$tag->id}}
                            </td>

                            <td>
                                <strong>{{$tag->name}}</strong>
                            </td>
                                                
                            <td>
                                {{ $tag->slug }}
                            </td>

                            {{--
                            <td>
                                @if($tag->open_status)
                                有効
                                @else
                                <span class="text-danger">無効</span>
                                @endif
                            </td>
                            --}}

                            <td>
                                <a style="margin:auto;" href="{{url('dashboard/tags/'.$tag->id)}}" class="btn btn-success btn-sm center-block">編集</a>
                            </td>
                            
                            <td>
                            	{{--
                                <form role="form" method="POST" action="{{ url('/dashboard/tags/'. $tag->id) }}">
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
        
    
    
    {{ $tags->links() }}
        
@endsection

