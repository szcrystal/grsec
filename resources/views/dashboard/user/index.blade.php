@extends('layouts.appDashBoard')

@section('content')

    <div class="text-left">
		<h1 class="Title">
  		@if($isUser)      
        <span class="">会員一覧</span>
        @else
        <span class="text-warning">非会員一覧</span>
        @endif
        </h1>
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

    {{-- $userObjs->links() --}}


    <!-- Example DataTables Card-->
    <div class="row">
    <div class="col-md-12">
    <div class="mb-3">
    	
     	   
        <div class="mb-3 text-right">
        	<?php $noR = ''; ?>
        	@if(Request::has('no_r'))
            	<?php $noR = '?no_r=1'; ?>
            @endif
            <a href="{{ url('dashboard/users/csv'. $noR) }}" class="btn btn-light border border-secondary px-3">CSV DL</a>
        </div>
        
        


        <div class="">
          <div class="table-responsive mt-5">
            <table id="dataTable" class="table table-striped table-bordered table-hover bg-white" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>ID</th>
                  <th style="min-width:5em;">名前</th>
                  <th style="min-width:12em;">住所</th>
                  <th style="min-width:8em;">メールアドレス</th>
                  <th>TEL</th>
                  @if($isUser) 
                  	<th>メルマガ</th>
                    <th style="min-width: 3em;">クレカ<br>登録</th>
                  @endif
                  <th>会員登録日</th>
                  <th></th>
                  
                </tr>
              </thead>
              
              <tbody>
              @foreach($userObjs as $user)
                <tr>
                  	<td>{{ $user->id }}</td>
                    <td style="word-break:break-all;">
                    	{{ $user->name }}
                    	@if(! $user->active)
                            <br><span class="text-warning"><b>[退会]</b></span>
                        @endif
                    </td>
                    <td>{{ $user->prefecture }}{{ $user->address_1 }}{{ $user->address_2 }}<br>{{ $user->address_3 }}</td>
                  	
                    <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                    <td>{{ $user->tel_num }}</td>
                    
                    @if($isUser)
                        <td>
                            @if($user->magazine)
                            <span class="text-success">登録済</span>
                            @else
                            <span class="text-warning">未登録</span>
                            @endif
                        </td>
                        
                        <td>
                            @if(isset($user->member_id))
                            	<span class="text-small">登録数：{{ $user->card_regist_count }}</span>
                            @else
                            	<span class="text-small">未登録</span>
                            @endif
                        </td>
                    @endif
                  
                  	<td><small>{{ Ctm::changeDate($user->created_at, 0) }}</small></td>
                  
                  <?php 
                  		$link = $user->id;
                        if(! $isUser) {
                            $link = $link . "?no_r=1";
                        }
                  ?>
                  <td>
                  	<a href="{{url('dashboard/users/'. $link)}}" class="btn btn-success btn-sm center-block">確認</a><br>
                	<small class="text-secondary ml-1">ID{{ $user->id }}</small>
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

