@extends('layouts.appDashBoard')

@section('content')
	
	<div class="text-left">
        <h1 class="Title">
        @if(isset($edit))
        メールテンプレート編集
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
            <a href="{{ url('/dashboard/mails') }}" class="btn bg-white border border-1 border-round border-secondary text-primary"><i class="fa fa-angle-double-left" aria-hidden="true"></i>一覧へ戻る</a>
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
        
    <div class="col-lg-11">
        <form class="form-horizontal" role="form" method="POST" action="/dashboard/mails" enctype="multipart/form-data">

            {{ csrf_field() }}
            
            @if(isset($edit))
                <input type="hidden" name="edit_id" value="{{$id}}">
            @endif
		

			<fieldset class="mb-4 form-group{{ $errors->has('type_name') ? ' has-error' : '' }}">
                <label>種類</label><span class="mx-3">変更不可（メールには記載されない）</span>
                <input class="form-control{{ $errors->has('type') ? ' is-invalid' : '' }}" name="type_name" value="{{ Ctm::isOld() ? old('type_name') : (isset($mailTemplate) ? $mailTemplate->type_name : '') }}" disabled>

                @if ($errors->has('type_name'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('type_name') }}</span>
                    </div>
                @endif
            </fieldset>
            
            <fieldset class="mb-4 form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                <label>件名</label>
                <input class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ Ctm::isOld() ? old('title') : (isset($mailTemplate) ? $mailTemplate->title : '') }}">

                @if ($errors->has('title'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('title') }}</span>
                    </div>
                @endif
            </fieldset>
            
            <fieldset class="mb-4 form-group{{ $errors->has('header') ? ' has-error' : '' }}">
                    <label for="header" class="control-label">ヘッダー</label>
                    <span class="mx-3">各種情報等の前に挿入される</span>

                    <textarea id="header" type="text" class="form-control" name="header" rows="10">{{ Ctm::isOld() ? old('header') : (isset($mailTemplate) ? $mailTemplate->header : '') }}</textarea>

                    @if ($errors->has('header'))
                        <span class="help-block">
                            <strong>{{ $errors->first('header') }}</strong>
                        </span>
                    @endif
            </fieldset>
            
            <fieldset class="mb-4 form-group{{ $errors->has('footer') ? ' has-error' : '' }}">
                    <label for="footer" class="control-label">フッター</label>
					<span class="mx-3">各種情報等の後に挿入される</span>
                    
                    <textarea id="footer" type="text" class="form-control" name="footer" rows="10">{{ Ctm::isOld() ? old('footer') : (isset($mailTemplate) ? $mailTemplate->footer : '') }}</textarea>

                    @if ($errors->has('footer'))
                        <span class="help-block">
                            <strong>{{ $errors->first('footer') }}</strong>
                        </span>
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
