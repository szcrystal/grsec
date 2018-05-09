@extends('layouts.appDashBoard')

@section('content')
	
	<div class="text-left">
        <h1 class="Title">
        @if(isset($edit))
        サイト設定編集
        @else
        サイト設定編集
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
        
    <div class="col-lg-10">
        <form class="form-horizontal" role="form" method="POST" action="/dashboard/settings" enctype="multipart/form-data">

            {{ csrf_field() }}
            
            @if(isset($edit))
                <input type="hidden" name="edit_id" value="{{$id}}">
            @endif
		
			<fieldset class="mb-4 form-group{{ $errors->has('admin_name') ? ' has-error' : '' }}">
                <label>管理者名</label>
                <input class="form-control{{ $errors->has('admin_name') ? ' is-invalid' : '' }}" name="admin_name" value="{{ Ctm::isOld() ? old('admin_name') : (isset($setting) ? $setting->admin_name : '') }}">

                @if ($errors->has('admin_name'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('admin_name') }}</span>
                    </div>
                @endif
            </fieldset>
            
            <fieldset class="mb-4 form-group{{ $errors->has('admin_email') ? ' has-error' : '' }}">
                <label>管理者メールアドレス</label>
                <input class="form-control{{ $errors->has('admin_email') ? ' is-invalid' : '' }}" name="admin_email" value="{{ Ctm::isOld() ? old('admin_email') : (isset($setting) ? $setting->admin_email : '') }}">

                @if ($errors->has('admin_email'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('admin_email') }}</span>
                    </div>
                @endif
            </fieldset>
            
            
            
            
            <fieldset class="mb-4 form-group{{ $errors->has('mail_footer') ? ' has-error' : '' }}">
                    <label for="mail_footer" class="control-label">共通メールフッター</label>

                    <textarea id="mail_footer" type="text" class="form-control" name="mail_footer" rows="15">{{ Ctm::isOld() ? old('mail_footer') : (isset($setting) ? $setting->mail_footer : '') }}</textarea>

                    @if ($errors->has('mail_footer'))
                        <span class="help-block">
                            <strong>{{ $errors->first('mail_footer') }}</strong>
                        </span>
                    @endif
            </fieldset>
            
            <hr class="my-5">
            
            <fieldset class="mb-4 form-group{{ $errors->has('tax_per') ? ' has-error' : '' }}">
                <label>消費税率</label><br>
                <input class="form-control d-inline-block col-md-4{{ $errors->has('tax_per') ? ' is-invalid' : '' }}" name="tax_per" value="{{ Ctm::isOld() ? old('tax_per') : (isset($setting) ? $setting->tax_per : '') }}"> <span>%</span>

                @if ($errors->has('tax_per'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('tax_per') }}</span>
                    </div>
                @endif
            </fieldset>
            
            <fieldset class="mb-4 form-group{{ $errors->has('bank_info') ? ' has-error' : '' }}">
                    <label for="bank_info" class="control-label">銀行振込先</label>

                    <textarea id="bank_info" type="text" class="form-control" name="bank_info" rows="8">{{ Ctm::isOld() ? old('bank_info') : (isset($setting) ? $setting->bank_info : '') }}</textarea>

                    @if ($errors->has('bank_info'))
                        <span class="help-block">
                            <strong>{{ $errors->first('bank_info') }}</strong>
                        </span>
                    @endif
            </fieldset>
            
        
            
            <div class="form-group">
                <div class="">
                    <button type="submit" class="btn btn-primary d-block w-25 mt-5 mx-auto"><span class="octicon octicon-sync"></span>更　新</button>
                </div>
            </div>


            

        </form>

    </div>

    

@endsection
