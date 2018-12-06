@extends('layouts.appDashBoard')

@section('content')

    <div class="text-left">
		<h1 class="Title"> メールテンプレート一覧</h1>
		<p class="Description text-info">メールテンプレートの新規追加は出来ません</p>
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

    {{ $mailTemplates->links() }}


    <!-- Example DataTables Card-->
    <div class="row">
    <div class="col-md-12 mb-3">
    	<!--
        <div class="card-header">
            <i class="fa fa-table"></i> Data Table Example
        </div>
        -->




        <div class="">
          <div class="table-responsive">
            <table id="dataTable" class="table table-striped table-bordered table-hover bg-white" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>種類</th>
                  <th>件名</th>
                  <th>ヘッダー</th>
                  <th>フッター</th>
                  
                  {{-- <th>作成日</th> --}}
                  
                  <th></th>
                  <th></th>
                </tr>
              </thead>
              
              <tbody>
              @foreach($mailTemplates as $obj)
                <tr>
                  <td>{{ $obj->id }}</td>

                  <td>{{ $obj->type_name }}</td>
                  <td>{{ $obj->title }}</td>
                  
                  <td>{{ Ctm::shortStr($obj->header, 20) }}</td>
                  
                  <td>{{ Ctm::shortStr($obj->footer, 20) }}</td>
                  
                  {{--
                  <td>{{ Ctm::changeDate($consignor->created_at, 1) }}</td>
                  --}}
                  
                  <td><a href="{{url('dashboard/mails/'. $obj->id)}}" class="btn btn-success btn-sm center-block">編集</a></td>
                  <td></td>
                </tr>
            @endforeach

              </tbody>
            </table>
          </div>
          
        </div>

        <!-- <div class="card-footer small text-muted"></div> -->

    </div><!-- /.card -->
    
    {{ $mailTemplates->links() }}
    
    
    </div>

        
@endsection

