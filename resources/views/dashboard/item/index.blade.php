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

    {{ $itemObjs->links() }}


    <!-- Example DataTables Card-->
    <div class="row">
    <div class="col-md-12">
    <div class="mb-3">
    	
        <div class="mb-3 text-right">
            <a href="{{url('dashboard/items/create')}}" class="btn btn-info">商品新規追加</a>
        </div>
        


        <div class="">
          <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover bg-white"{{-- id="dataTable"--}} width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>商品番号</th>
                  <th>画像</th>
                  <th>商品名</th>
                  <th>カテゴリー</th>
                  <th>金額</th>
                  <th>説明</th>
                  <th>ステータス</th>
                  <th>作成日</th>
                  <th></th>
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
                  <td>{{ $item->id }}</td>
                  <td>{{ $item->number }}</td>
                  <td>
                  @if($item->main_img != '')
                  <img src="{{ Storage::url($item->main_img) }}" width="80" height="60"></td>
                  @else
                  <span class="no-img">No Image</span>
                  @endif
                  <td>{{ $item->title }}</td>
                  <td>{{ $cates->find($item->cate_id)->name }}</td>
                  <td>{{ number_format($item->price) }}</td>
                  
                  <td>{{-- $item->what_is --}}</td>
                  <td>
                    @if($item->open_status)
                    <span class="text-success">公開中</span>
                    @else
                    <span class="text-warning">未公開（保存済）</span>
                    @endif

                </td>
                  <td><small>{{ Ctm::changeDate($item->created_at, 1) }}</small></td>
                  
                  <td><a href="{{url('dashboard/items/'. $item->id)}}" class="btn btn-success btn-sm center-block">編集</a></td>
                  <td></td>
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

