@extends('layouts.appDashBoard')

@section('content')

    <div class="text-left">
		<h1 class="Title"> 配送会社一覧</h1>
		<p class="Description"></p>
    </div>


    <div class="row">


    </div>
    <!-- /.row -->


  
    {{--
    <div class="row -row-compact-sm -row-compact-md -row-compact-lg">
      <div class="col-sm-12 col-md-6 col-lg-6 col-xl-5 -sameheight">
        <div class="Card DashboardStats">
            <form role="form" method="POST" action="">
                <div class="form-group input-group">
                    <input type="text" class="form-control">
                    <span class="input-group-btn">
                        <button class="btn btn-secondary" type="button"><i class="fa fa-search"></i></button>
                    </span>
                </div>
            </form>
          </div>
    	</div>
  	</div>
   --}}   


	<div class="row">
	@if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    </div>

    {{-- $dgs->links() --}}


    <!-- Example DataTables Card-->
    <div class="row">
    <div class="col-md-12">
    <div class="mb-3">
    	<div class="mb-3 text-right">
            <a href="{{url('dashboard/dcs/create')}}" class="btn btn-info">新規追加</a>
        </div>


        <div class="">
        <div class="table-responsive">
        	<table id="dataTable" class="table table-striped table-bordered table-hover bg-white"{{-- id="dataTable"--}} width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>配送会社名</th>
                  <th>配送状況確認用URL</th>
                  <th></th>
                  <th></th>
                </tr>
              </thead>
              
 
              <tbody>
              @foreach($dcs as $dc)
                <tr>
                  <td>{{ $dc->id }}</td>
                  
                  <td>{{ $dc->name }}</td>
                  
                  <td><a href="{{ $dc->url }}" target="_brank">{{ $dc->url }}</a></td>
                
                  
                  <td><a href="{{url('dashboard/dcs/'. $dc->id)}}" class="btn btn-success btn-sm center-block">編集</a></td>
                  
                  <td>
                  	<form role="form" method="POST" action="{{ url('/dashboard/dcs/'. $dc->id) }}">
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
        </div>

        <!-- <div class="card-footer small text-muted"></div> -->

    </div><!-- /.card -->
    </div>
    </div>

        
@endsection

