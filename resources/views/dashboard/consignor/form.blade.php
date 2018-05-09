@extends('layouts.appDashBoard')

@section('content')
	
	<div class="text-left">
        <h1 class="Title">
        @if(isset($edit))
        出荷元編集
        @else
        出荷元新規追加
        @endif
        </h1>
        <p class="Description"></p>
    </div>

    <div class="row">
      <div class="col-sm-12 col-md-6 col-lg-6 col-xl-5 mb-5">
        <div class="bs-component clearfix">
        <div class="pull-left">
            <a href="{{ url('/dashboard/consignors') }}" class="btn bg-white border border-1 border-round border-secondary text-primary"><i class="fa fa-angle-double-left" aria-hidden="true"></i>一覧へ戻る</a>
        </div>
    	</div>
    </div>
  </div>



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
        
    <div class="col-lg-12">
        <form class="form-horizontal" role="form" method="POST" action="/dashboard/consignors" enctype="multipart/form-data">

            {{ csrf_field() }}
            
            @if(isset($edit))
                <input type="hidden" name="edit_id" value="{{$id}}">
            @endif
		
        
	
		           
  
        
			<fieldset class="mb-4 form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label>出荷元名</label>
                <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ Ctm::isOld() ? old('name') : (isset($consignor) ? $consignor->name : '') }}">

                @if ($errors->has('name'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('name') }}</span>
                    </div>
                @endif
            </fieldset>
            
        
            
            <div class="form-group">
                <div class="">
                    <button type="submit" class="btn btn-primary {{--btn-block --}}w-btn w-25 mt-3 mx-auto"><span class="octicon octicon-sync"></span>更　新</button>
                </div>
            </div>


            

        </form>

    </div>

    

@endsection
