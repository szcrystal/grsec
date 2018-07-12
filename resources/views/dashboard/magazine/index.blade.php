@extends('layouts.appDashBoard')

@section('content')

    <div class="text-left">
		<h1 class="Title"> メルマガ一覧</h1>
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

    {{-- $itemObjs->links() --}}


    <!-- Example DataTables Card-->
    <div class="row">
    <div class="col-md-12">
    <div class="mb-3">
    	
        <div class="mb-5 text-right">
            <a href="{{url('dashboard/magazines/create')}}" class="btn btn-info">新規追加</a>
        </div>
        
		{{--
		<div>
        	<span class="changeSearch">SEARCH</span>
        </div>
        --}}
        
        <style>
        	.w-5 {
            	width: 5%;
            }
        </style>
        
        <div class="">
          <div class="table-responsive">
            <table id="dataTable" class="table table-striped table-bordered table-hover bg-white" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>タイトル</th>
                  <th>コンテンツ</th>
                  <th>送信</th>
                  <th>作成日</th>
                  <th></th>
                </tr>
              </thead>
              
              
              <tbody>
              @foreach($magObjs as $mag)
                <tr>
                  <td>{{ $mag->id }}</td>
                
                <td>
                	{{ $mag->title }}
                </td>
                
                <td>
                	{{ Ctm::shortStr($mag->contents, 100) }}
                </td>
                

                
                <td>
                  	@if($mag->is_send)
                    <span class="text-success">送信済</span><br>
                    <small>{{ Ctm::changeDate($mag->send_date, 0) }}</small><br>
                    @else
                    <span class="text-warning">未送信（保存済）</span><br>
                    @endif
                  	
                </td>
                
                <td>{{ Ctm::changeDate($mag->created_at, 0) }}</td>
                  
                  <td><a href="{{url('dashboard/magazines/'. $mag->id)}}" class="btn btn-success btn-sm center-block">編集</a></td>
                  
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
    
    {{-- $itemObjs->links() --}}

        
@endsection

