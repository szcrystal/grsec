@extends('layouts.app')

@section('content')


	{{-- @include('main.shared.carousel') --}}

<div id="main" class="top">

        <div class="panel panel-default">

            <div class="panel-body">
                {{-- @include('main.shared.main') --}}

				<div class="main-list clearfix">


<div class="top-cont feature clear">

<h2 class="mb-3">お客様情報入力</h2>

<div class="col-lg-10">
        <form class="form-horizontal" role="form" method="POST" action="{{ url('cart/payment') }}">

            {{ csrf_field() }}            

		
    		<input type="hidden" name="item_id" value="{{ $data['item_id'] }}">
            <input type="hidden" name="price" value="{{ $data['price'] }}">
            <input type="hidden" name="tax" value="{{ $data['tax'] }}">      
            <input type="hidden" name="count" value="1">
        

            <fieldset class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label>お名前</label>
                <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ Ctm::isOld() ? old('name') : (isset($item) ? $item->name : '') }}">

                @if ($errors->has('name'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('name') }}</span>
                    </div>
                @endif
            </fieldset>
            
            <fieldset class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label>住所１</label>
                <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ Ctm::isOld() ? old('name') : (isset($item) ? $item->name : '') }}">

                @if ($errors->has('name'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('name') }}</span>
                    </div>
                @endif
            </fieldset>
            
            <fieldset class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label>住所２</label>
                <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ Ctm::isOld() ? old('name') : (isset($item) ? $item->name : '') }}">

                @if ($errors->has('name'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('name') }}</span>
                    </div>
                @endif
            </fieldset>
            
            <fieldset class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label>電話番号</label>
                <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ Ctm::isOld() ? old('name') : (isset($item) ? $item->name : '') }}">

                @if ($errors->has('name'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('name') }}</span>
                    </div>
                @endif
            </fieldset>
            
            <fieldset class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label>メールアドレス</label>
                <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ Ctm::isOld() ? old('name') : (isset($item) ? $item->email : '') }}">

                @if ($errors->has('email'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('email') }}</span>
                    </div>
                @endif
            </fieldset>
            
            <fieldset class="form-group">
                    <label>お支払い方法</label><br>
                    <label class="radio-inline">
                        <input type="radio" name="card" id="optionsRadiosInline1" value="card" checked>クレジットカード
                    </label>
                    <br>
                    <label class="radio-inline">
                        <input type="radio" name="optionsRadiosInline" id="optionsRadiosInline2" value="option2">コンビニ決済
                    </label>
                    <br>
                    <label class="radio-inline">
                        <input type="radio" name="optionsRadiosInline" id="optionsRadiosInline3" value="option3">代引き決済
                    </label>
                    <br>
                    {{--
                    <label class="radio-inline">
                        <input type="radio" name="optionsRadiosInline" id="optionsRadiosInline3" value="option3">配送サービス
                    </label>
                    --}}
                    
                    {{--
                    <label class="radio-inline">
                        <input type="radio" name="optionsRadiosInline" id="optionsRadiosInline3" value="option3">ネット銀行決済
                    </label>
                    --}}
                </fieldset>
            
            
            <fieldset class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            	<label>備考</label>
            	<textarea rows="7" name="other"></textarea>
            </fieldset>
            
            
            
            
            
            
            
            
            <div class="form-group">
                <div class="col-md-4 col-md-offset-3">
                    <button type="submit" class="btn btn-warning center-block w-btn"><span class="octicon octicon-sync"></span>カートへ</button>
                </div>
            </div>


            

        </form>

    </div>

</div>






</div>

            </div>
        </div>

</div>

@endsection


{{--
@section('leftbar')
    @include('main.shared.leftbar')
@endsection


@section('rightbar')
	@include('main.shared.rightbar')
@endsection
--}}


