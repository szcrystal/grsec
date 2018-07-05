@extends('layouts.appDashBoard')

@section('content')
	
	<div class="text-left">
        <h1 class="Title">
        @if(isset($edit))
        送料編集
        @else
        送料新規追加
        @endif
        </h1>
        <p class="Description"></p>
    </div>

    <div class="row">
      <div class="col-sm-12 col-md-6 col-lg-6 col-xl-5 mb-5">
        <div class="bs-component clearfix">
        <div class="pull-left">
            <a href="{{ url('/dashboard/dgs') }}" class="btn bg-white border border-1 border-round border-secondary text-primary"><i class="fa fa-angle-double-left" aria-hidden="true"></i>一覧へ戻る</a>
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
        
    <div class="col-lg-12 mb-5">
    	<h3>{{ $dg->name }}</h3>
        <hr>
        
        
        <form class="form-horizontal" role="form" method="POST" action="/dashboard/dgs/fee/{{$id}}" enctype="multipart/form-data">
        
        	<div class="form-group mt-4 mb-4">
                <div class="clearfix">
                    <button type="submit" class="btn btn-primary btn-block mx-auto w-btn w-25">更　新</button>
                </div>
            </div>
            
            <p class="text-success mt-2 mb-3 text-big"><i class="fa fa-exclamation"></i> 配送不可の地域については、-（ハイフン）を入力して下さい。</p>
        

            {{ csrf_field() }}
            
            @if(isset($edit))
                <input type="hidden" name="edit_id" value="{{$id}}">
            @endif
            
            <fieldset class="mt-5 mb-5 pt-3 form-group{{ $errors->has('fee.all') ? ' has-error' : '' }}">
                <label style="width:10%;">一括設定</label>
                
                {{-- <input type="hidden" name="pref_id[all]" value="99"> --}}
                <input class="form-control d-inline-block col-md-4{{ $errors->has('fee.all') ? ' is-invalid' : '' }}" name="fee[all]" value="{{ Ctm::isOld() ? old('fee.all') : '' }}">

                @if ($errors->has('fee.all'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('fee.all') }}</span>
                    </div>
                @endif
            </fieldset>
            
            <hr class="mb-5 w-50 mx-0">
 
            
            @foreach($prefs as $key => $pref)
            <fieldset class="mb-2 form-group{{ $errors->has('fee.'.$key) ? ' has-error' : '' }}">
                <label style="width:10%;">{{ $pref->name }}</label>
                <?php
                	$prefFee = $dgRels-> where('pref_id', $pref->id)->first();
                    
                ?>
                <input type="hidden" name="pref_id[]" value="{{ $pref->id }}">
                <input class="form-control d-inline-block col-md-4{{ $errors->has('fee.'.$key) ? ' is-invalid' : '' }}" name="fee[]" value="{{ Ctm::isOld() ? old('fee.'.$key) : (isset($prefFee) ? $prefFee->fee : '') }}">

                @if ($errors->has('fee.'.$key))
                    <div class="text-danger mb-2">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('fee.'.$key) }}</span>
                    </div>
                @endif
            </fieldset>
            
            @endforeach
            
            
            
            
            <div class="form-group pt-4">
                <div class="">
                    <button type="submit" class="btn btn-primary btn-block w-btn w-25 mx-auto">更　新</button>
                </div>
            </div>


            

        </form>

    </div>

    

@endsection
