@extends('layouts.appDashBoard')

@section('content')

    <div class="text-left">
		<h1 class="Title"> 出荷元一覧</h1>
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

    {{ $consignors->links() }}


    <!-- Example DataTables Card-->
    <div class="row">
    <div class="col-md-12 mb-3">
    	<div class="mb-3 text-right">
            <a href="{{url('dashboard/consignors/create')}}" class="btn btn-info">新規追加</a>
        </div>




        <div class="">
          <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover bg-white"{{-- id="dataTable"--}} width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>名前</th>
                  {{--
                  <th class="col-md-2">商品名</th>
                  <th>カテゴリー</th>
                  <th>金額</th>
                  <th>説明</th>
                  <th>ステータス</th>
                  --}}
                  <th>作成日</th>
                  
                  <th></th>
                  <th></th>
                </tr>
              </thead>
              
              <tbody>
              @foreach($consignors as $consignor)
                <tr>
                  <td>{{ $consignor->id }}</td>

                  <td>{{ $consignor->name }}</td>
                  
                  <td>{{ Ctm::changeDate($consignor->created_at, 1) }}</td>
                  
                  <td><a href="{{url('dashboard/consignors/'. $consignor->id)}}" class="btn btn-success btn-sm center-block">編集</a></td>
                  <td></td>
                </tr>
            @endforeach

              </tbody>
            </table>
          </div>
          
        </div>

        <!-- <div class="card-footer small text-muted"></div> -->

    </div><!-- /.card -->
    
    {{ $consignors->links() }}
    
    
    </div>

        
@endsection

