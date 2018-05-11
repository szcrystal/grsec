@extends('layouts.appDashBoard')

@section('content')

    <div class="text-left">
		<h1 class="Title"> 会員一覧</h1>
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

    {{ $userObjs->links() }}


    <!-- Example DataTables Card-->
    <div class="row">
    <div class="col-md-12">
    <div class="mb-3">
    	
     	{{--   
        <div class="mb-3 text-right">
            <a href="{{url('dashboard/items/create')}}" class="btn btn-info">商品新規追加</a>
        </div>
        --}}
        


        <div class="">
          <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover bg-white"{{-- id="dataTable"--}} width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>名前</th>
                  <th>性別</th>
                  <th>生年月日</th>
                  <th>都道府県</th>
                  <th>eMail</th>
                  <th>メルマガ</th>
                  <th>登録日</th>
                  <th></th>
                  <th></th>
                </tr>
              </thead>
              
              <tbody>
              @foreach($userObjs as $user)
                <tr>
                  <td>{{ $user->id }}</td>
                  <td>{{ $user->name }}</td>
                  <td>{{ $user->gender }}</td>
                  <td>{{ $user->birth_year }}/{{ $user->birth_month }}/{{ $user->birth_day }}</td>
                  <td>{{ $user->prefecture }}</td>
                  
                  <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                  <td>
                  	@if($user->magazine)
                  	<span class="text-info">登録済</span>
                    @else
                    <span class="text-warning">未登録</span>
                    @endif
                	</td>
                  
                  <td><small>{{ Ctm::changeDate($user->created_at, 1) }}</small></td>
                  
                  
                  <td><a href="{{url('dashboard/users/'. $user->id)}}" class="btn btn-success btn-sm center-block">確認</a></td>
                  
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

