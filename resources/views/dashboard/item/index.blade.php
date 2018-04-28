@extends('layouts.appDashBoard')

@section('content')

    <div class="text-left">
		<h1 class="Title"> 商品一覧</h1>
		<p class="Description"></p>
    </div>


    <div class="row">


    </div>
    <!-- /.row -->


  
    
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


	<div class="row">
	@if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    </div>

    {{-- $atclObjs->links() --}}


    <!-- Example DataTables Card-->
    <div class="row">
    <div class="col-md-12">
    <div class="card mb-3">
    	<!--
        <div class="card-header">
            <i class="fa fa-table"></i> Data Table Example
        </div>
        -->




        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Position</th>
                  <th>Office</th>
                  <th>Age</th>
                  <th>Start date</th>
                  <th>Salary</th>
                  <th></th>
                </tr>
              </thead>
              
              <!--
              <tfoot>
                <tr>
                  <th>Name</th>
                  <th>Position</th>
                  <th>Office</th>
                  <th>Age</th>
                  <th>Start date</th>
                  <th>Salary</th>
                  <th></th>
                </tr>
              </tfoot>
              -->
              
              <tbody>
              @foreach($itemObjs as $item)
                <tr>
                  <td>{{ $item->name }}</td>
                  <td>{{ $item->cate }}</td>
                  <td></td>
                  <td></td>
                  <td>{{ $item-> created_at}}</td>
                  <td></td>
                  <td><a href="{{url('dashboard/items/'. $item->id)}}" class="btn btn-success btn-sm center-block">編集</a></td>
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

