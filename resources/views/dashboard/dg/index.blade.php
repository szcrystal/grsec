@extends('layouts.appDashBoard')

@section('content')

    <div class="text-left">
		<h1 class="Title"> 配送区分一覧</h1>
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
            <a href="{{url('dashboard/dgs/create')}}" class="btn btn-info">新規追加</a>
        </div>


        <div class="">
        <div class="table-responsive">
        	<table id="dataTable" class="table table-striped table-bordered table-hover bg-white"{{-- id="dataTable"--}} width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>配送区分名</th>
                  <th>送料状態</th>
                  <th>容量</th>
                  {{-- <th>係数</th> --}}
                  <th>時間指定</th>
                  <th></th>
                  <th></th>
                </tr>
              </thead>
              
 
              <tbody>
              @foreach($dgs as $dg)
                <tr>
                  <td>{{ $dg->id }}</td>
                  
                  <td>{{ $dg->name }}</td>
                  
                  <td>
                  <?php
                  	$result = 1;
                    
            		$feeObjs = $dgRels->where(['dg_id'=>$dg->id])->get();
                    
                    foreach($feeObjs as $obj) {
                    	if($obj->fee === null) {
                        	$result = 0;
                            break;
                        }
                    }
                	?>
                    
                	@if(count($feeObjs) < 47 || ! $result)
                		<span class="text-danger"><b>送料が未入力の都道府県があります</b></span>
                   @endif
                   
                      
                  </td>
                  
                  <td>{{ $dg->capacity }}</td>
                  
                  {{-- <td>{{ $dg->factor }}</td> --}}
                  
                  <td>
                  @if($dg->is_time)
                  <span class="text-success">可能</span>
                  @else
                  <span class="text-danger">不可</span>
                  @endif	
                  </td>
                  
                  {{--
                  <td>
                    @if($dg->open_status)
                    <span class="text-success">公開中</span>
                    @else
                    <span class="text-warning">未公開（保存済）</span>
                    @endif
                </td>
                --}}
                
                  
                  <td><a href="{{url('dashboard/dgs/'. $dg->id)}}" class="btn btn-success btn-sm center-block">配送区分編集</a></td>
                  <td><a href="{{url('dashboard/dgs/fee/'. $dg->id)}}" class="btn btn-warning btn-sm center-block">送料編集</a></td>
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

