@extends('layouts.appDashBoard')

@section('content')
	
	<div class="text-left">
        <h1 class="Title">
        @if(isset($edit))
        メルマガ編集
        @else
        商品メルマガ追加
        @endif
        </h1>
        <p class="Description"></p>
    </div>

    <div class="row">
      <div class="col-md-12 mb-5">
        <div class="bs-component clearfix">
        <div class="">
            <a href="{{ url('/dashboard/magazines') }}" class="btn bg-white border border-1 border-round border-secondary text-primary"><i class="fa fa-angle-double-left" aria-hidden="true"></i>一覧へ戻る</a>
        </div>
        
        {{--
        @if(isset($edit))
        <div class="mt-4 text-right">
            <a href="{{ url('/item/'. $id) }}" class="btn btn-warning border border-1 border-round text-white" target="_brank">この商品のページを見る <i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
        </div>
        @endif
        --}}
        
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
        <form class="form-horizontal" role="form" method="POST" action="/dashboard/magazines" enctype="multipart/form-data">

            {{ csrf_field() }}
            
            @if(isset($edit))
                <input type="hidden" name="edit_id" value="{{$id}}">
            @endif

        
			<fieldset class="mb-4 form-group">
                <label>タイトル</label>
                <input class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="number" value="{{ Ctm::isOld() ? old('title') : (isset($mag) ? $mag->title : '') }}">

                @if ($errors->has('title'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('title') }}</span>
                    </div>
                @endif
            </fieldset>
               
            
            <fieldset class="my-5 form-group">
                    <label for="explain" class="control-label">コンテンツ</label>

                    <textarea id="contents" type="text" class="form-control{{ $errors->has('contents') ? ' is-invalid' : '' }}" name="contents" rows="25">{{ Ctm::isOld() ? old('contents') : (isset($mag) ? $mag->contents : '') }}</textarea>

                    @if ($errors->has('contents'))
                        <div class="text-danger">
                            <span class="fa fa-exclamation form-control-feedback"></span>
                            <span>{{ $errors->first('slug') }}</span>
                        </div>
                    @endif
            </fieldset>
            
            <div class="clearfix">
                <div class="form-group mb-5 col-md-6 float-left">
                    <button type="submit" class="btn btn-primary btn-block w-50" name="only_up" value="1" disabled>送信せずに更新</button>
                </div>
                
                <div class="form-group col-md-6 float-right">
                    <button type="submit" class="btn btn-danger btn-block mx-auto w-btn w-50 float-right" name="with_mail" value="1" disabled>メール送信する</button>
                </div>
            </div>
            

        </form>

    </div>

    

@endsection
