@extends('layouts.appDashBoard')

@section('content')
	
	<div class="text-left">
        <h1 class="Title">
        @if(isset($edit))
        配送会社編集
        @else
        配送会社新規追加
        @endif
        </h1>
        <p class="Description"></p>
    </div>

    <div class="row">
      <div class="col-sm-12 col-md-6 col-lg-6 col-xl-5 mb-5">
        <div class="bs-component clearfix">
        <div class="pull-left">
            <a href="{{ url('/dashboard/dcs') }}" class="btn bg-white border border-1 border-round border-secondary text-primary"><i class="fa fa-angle-double-left" aria-hidden="true"></i>一覧へ戻る</a>
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
        <form class="form-horizontal" role="form" method="POST" action="/dashboard/dcs" enctype="multipart/form-data">
        
        	{{--
        	<div class="form-group mb-5">
                <div class="clearfix">
                    <button type="submit" class="btn btn-primary btn-block mx-auto w-btn w-25">更　新</button>
                </div>
            </div>
            --}}
        
            {{ csrf_field() }}
            
            @if(isset($edit))
                <input type="hidden" name="edit_id" value="{{$id}}">
            @endif
		
  		{{--      
		<div class="form-group">
                <div class="col-md-12 text-right">
                    <div class="checkbox">
                        <label>
        --}}
                            <?php
//                                $checked = '';
//                                if(Ctm::isOld()) {
//                                    if(old('open_status'))
//                                        $checked = ' checked';
//                                }
//                                else {
//                                    if(isset($atcl) && ! $atcl->open_status) {
//                                        $checked = ' checked';
//                                    }
//                                }
                            ?>
        {{--
                            <input type="checkbox" name="open_status" value="1"{{ $checked }}> この配送区分を非公開にする
                        </label>
                    </div>
                </div>
            </div>
        --}}
	
		           

			<fieldset class="mb-4 form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label>配送会社名 <span class="text-danger text-small">*</span></label>
                <input class="form-control col-md-6{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ Ctm::isOld() ? old('name') : (isset($dc) ? $dc->name : '') }}">

                @if ($errors->has('name'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('name') }}</span>
                    </div>
                @endif
            </fieldset>
            
            <fieldset class="mb-4 form-group">
                <label for="name_code" class="control-label">コードネーム <span class="text-danger text-small">*</span>（半角英数字にて。スラッグと同等と考えて構いません。）</label>
                <input class="form-control col-md-6{{ $errors->has('name_code') ? ' is-invalid' : '' }}" name="name_code" value="{{ Ctm::isOld() ? old('name_code') : (isset($dc) ? $dc->name_code : '') }}">
                

                @if ($errors->has('name_code'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('name_code') }}</span>
                    </div>
                @endif
            </fieldset>
            
            <fieldset class="mb-4 form-group">
                <label for="url" class="control-label">配送状況確認用URL</label>
                <input class="form-control col-md-12{{ $errors->has('url') ? ' is-invalid' : '' }}" name="url" value="{{ Ctm::isOld() ? old('url') : (isset($dc) ? $dc->url : '') }}">
                

                @if ($errors->has('url'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('url') }}</span>
                    </div>
                @endif
            </fieldset>
            
            

            <div class="form-group">
                
                <button type="submit" class="btn btn-primary btn-block w-btn w-25 my-5">更　新</button>
                
            </div>


            

        </form>

    </div>

    

@endsection
