@extends('layouts.app')

@section('content')


	{{-- @include('main.shared.carousel') --}}

<div id="main" class="top">

        <div class="panel panel-default">

            <div class="panel-body">
                {{-- @include('main.shared.main') --}}

				<div class="main-list clearfix">
<h3 class="mb-3 card-header">会員を退会する</h3>
<p>以下の情報を入力して「退会する」ボタンを押して下さい。<br>退会後はログインできなくなり、購入履歴などの閲覧が不可となります。</p>

<div class="my-5 col-md-10 mx-auto">
@if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong><i class="fas fa-exclamation-triangle"></i> Error!!</strong> 以下の入力を確認して下さい。<br><br>
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



<form class="form-horizontal" role="form" method="POST" action="{{ url('mypage/optout') }}">

    {{ csrf_field() }}

<div class="table-responsive table-custom">
    <table class="table table-borderd border">

         <tr class="form-group">
             <th><label class="control-label">メールアドレス</label><em>必須</em></th>
               <td>
                <input type="email" class="form-control rounded-0 col-md-12{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ Ctm::isOld() ? old('email') : (isset($user) ? $user->email : '') }}" placeholder="例）abcde@example.com">
                
                @if ($errors->has('email'))
                    <div class="help-block text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('email') }}</span>
                    </div>
                @endif
            </td>
         </tr>
         
         <tr class="form-group">
             <th><label class="control-label">パスワード</label><em>必須</em></th>
               <td>
                <input type="password" class="form-control rounded-0 col-md-12{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" value="{{ old('password') }}" placeholder="8文字以上">
                                    
                @if ($errors->has('password'))
                    <div class="help-block text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('password') }}</span>
                    </div>
                @endif
            </td>
         </tr>
         
    </table>
</div>

	<button class="btn btn-block btn-custom col-md-3 my-4 mx-auto py-2" type="submit" name="recognize" value="1">退会する</button>                 
    </form>

</div>

<a href="{{ url('mypage') }}" class="btn border-secondary bg-white mt-5">
<i class="fas fa-angle-double-left"></i> マイページに戻る
</a>


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


