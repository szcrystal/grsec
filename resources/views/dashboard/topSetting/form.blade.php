@extends('layouts.appDashBoard')

@section('content')
	
	<div class="text-left">
        <h1 class="Title">
        @if(isset($edit))
        TOPページ設定編集
        @else
        TOPページ設定編集
        @endif
        </h1>
        <p class="Description"></p>
    </div>

{{--
    <div class="row">
      <div class="col-sm-12 col-md-6 col-lg-6 col-xl-5 mb-5">
        <div class="bs-component clearfix">
        <div class="pull-left">
            <a href="{{ url('/dashboard/consignors') }}" class="btn bg-white border border-1 border-round border-secondary text-primary"><i class="fa fa-angle-double-left" aria-hidden="true"></i>一覧へ戻る</a>
        </div>
    	</div>
    </div>
  </div>
--}}



    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Error!!</strong> 追加できません<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
        
	@if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
        
    <div class="col-lg-11">
        <form class="form-horizontal" role="form" method="POST" action="/dashboard/top-settings" enctype="multipart/form-data">
        	
         	<div class="form-group">
                <button type="submit" class="btn btn-primary d-block w-25 mt-5 mb-2 mx-auto"><span class="octicon octicon-sync"></span>更　新</button>
            </div>

            {{ csrf_field() }}
            
            @if(isset($edit))
                <input type="hidden" name="edit_id" value="{{$id}}">
            @endif
		
            
            <?php
            	$obj = null;
            	if(isset($setting)) $obj = $setting;
                
                $type = 'top';  
            ?>
            
            
            @include('dashboard.shared.contents')
            
            <label>メタ設定</label>
            @include('dashboard.shared.meta')
            
            
            

            
            <div class="form-group mt-3">
                <button type="submit" class="btn btn-primary d-block w-25 mt-5 mx-auto"><span class="octicon octicon-sync"></span>更　新</button>
            </div>


            

        </form>

    </div>

    

@endsection
