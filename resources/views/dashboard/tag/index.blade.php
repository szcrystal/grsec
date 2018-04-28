@extends('layouts.appDashBoard')

@section('content')

	<div class="clearfix">
    <h3 class="page-header">タグ一覧</h3>
    <a href="{{ url('/dashboard/tags/create') }}" class="btn btn-success pull-right mb-3">新規追加</a>
    </div>

    {{ $tags->links() }}
    
    
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
                                            <th class="w-50">タグ名</th>
                                            <th class="w-25">スラッグ</th>
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
                                                    <a style="margin:auto;" href="{{url('dashboard/tags/'.$tag->id)}}" class="btn btn-primary btn-sm center-block">編集</a>
                                                </td>
                                                
                                                <td>
                                                    <form role="form" method="POST" action="{{ url('/dashboard/tags/'. $tag->id) }}">
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
        
    
    
    {{ $tags->links() }}
        
@endsection

