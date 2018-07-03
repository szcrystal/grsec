@extends('layouts.appDashBoard')

@section('content')

    <div class="text-left">
		<h1 class="Title"> 商品一覧</h1>
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

    {{ $itemObjs->links() }}


    <!-- Example DataTables Card-->
    <div class="row">
    <div class="col-md-12">
    <div class="mb-3">
    	
        <div class="mb-5 text-right">
            <a href="{{url('dashboard/items/create')}}" class="btn btn-info">新規追加</a>
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
                  <th style="width: 5%;">商品番号</th>
                  <th>画像</th>
                  <th>商品名</th>
                  <th style="width:8%;">カテゴリー</th>
                  <th>金額</th>
                  <th>配送区分</th>
                  <th>在庫数</th>
                  <th>売上個数</th>
                  <th>作成日</th>
                  <th></th>
                  {{-- <th></th> --}}
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
                  <td class="text-small">{{ $item->number }}</td>
                  <td>
                  @if($item->main_img != '')
                  <img src="{{ Storage::url($item->main_img) }}" width="70" height="60"></td>
                  @else
                  <span class="no-img">No Image</span>
                  @endif
                  <td>{{ $item->title }}</td>
                  <td>
                  	@if(isset($item->cate_id))
                    	{{ $cates->find($item->cate_id)->link_name }}
                        @if(isset($item->subcate_id))
                        <br><small>{{ $subCates->find($item->subcate_id)->name }}</small>
                        @endif
                    @endif
                	</td>
                  <td>{{ number_format($item->price) }}</td>
                  
                  <td>
                  	@if(isset($item->dg_id))
                  	{{ $dgs->find($item->dg_id)->name }}<br>
                    @endif
                    <span class="text-info">同梱包：
                    @if($item->is_once)
                    	可
					@else
                    	不可
                    @endif
                    </span>
                </td>
                
                <td>
                	@if(! $item->stock)
                    	<span class="text-danger"><b>-0</b></span>
                    @else
                		{{ $item->stock }}
                    @endif
                </td>
                
                <td>
                	{{ $item->sale_count }}
                </td>
                

                
                <td>
                  	@if($item->open_status)
                    <span class="text-success">公開中</span><br>
                    @else
                    <span class="text-warning">未公開（保存済）</span><br>
                    @endif
                  	<small>{{ Ctm::changeDate($item->created_at, 1) }}</small>
                </td>
                  
                  <td><a href="{{url('dashboard/items/'. $item->id)}}" class="btn btn-success btn-sm center-block">編集</a></td>
                  
                  {{-- <td></td> --}}
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
    
    {{ $itemObjs->links() }}

        
@endsection

