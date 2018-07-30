@extends('layouts.app')

@section('content')
    <div class="row contact">
        <div class="col-md-12 mx-auto">
            <div class="panel panel-default">

                <div class="panel-heading">
                	<h2 class="card-header">お問い合わせ</h2>
                 	<p class="mt-4 pb-3">ここに何か説明を入れるなら<br>ここに何か説明を入れるなら<br>
                  
                  	</p>      
                </div>

                <div class="panel-body">

                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Error!!</strong> 確認して下さい。<br>
                            <ul class="mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

					<div class="table-responsive">
                    	<form class="form-horizontal" role="form" method="POST" action="/contact">
                            {{ csrf_field() }}

                            <input type="hidden" name="done_status" value="0">

                        <table class="table table-bordered table-custom">
                            <colgroup>
                                <col class="cth">
                                <col class="ctd">
                            </colgroup>
                            
                            <tbody>
                                <tr class="form-group">
                                	<th>お問い合わせ種別<em>必須</em></th>
                                    <td>
                                        <select class="form-control col-md-8{{ $errors->has('ask_category') ? ' is-invalid' : '' }}" name="ask_category">
                                        	<option disabled selected>選択して下さい</option>
                                            @foreach($cate_option as $val)
                                            	<?php
                                                    $selected = '';
                                                    if(Ctm::isOld()) {
                                                        if(old('ask_category') == $val)
                                                            $selected = ' selected';
                                                    }
                                                    else {
                                                        if(Session::has('contact') && session('contact.ask_category') == $val) {
                                                            $selected = ' selected';
                                                        }
                                                    }
                                                ?>
                                                <option value="{{ $val }}"{{ $selected }}>{{ $val }}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('ask_category'))
                                            <span class="text-danger">
                                            	<span class="fa fa-exclamation form-control-feedback"></span>
                                                <span>{{ $errors->first('ask_category') }}</span>
                                            </span>
                                        @endif

                                    </td>
                                </tr>


                                <tr class="form-group">
                                	<th><label class="control-label">お名前</label><em>必須</em></th>
                                   	<td>
                                    	<input class="form-control rounded-0 col-md-12{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ Ctm::isOld() ? old('name') : (Session::has('contact') ? session('contact.name') : '') }}" placeholder="例）山田太郎">
                                   
                                        @if ($errors->has('name'))
                                            <div class="text-danger">
                                                <span class="fa fa-exclamation form-control-feedback"></span>
                                                <span>{{ $errors->first('name') }}</span>
                                            </div>
                                        @endif
                                	</td>
                                </tr>

                                <tr class="form-group">
                                	<th><label class="control-label">メールアドレス</label><em>必須</em></th>
                                    <td>
                                    	<input class="form-control rounded-0 col-md-12{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ Ctm::isOld() ? old('email') : (Session::has('contact') ? session('contact.email') : '') }}" placeholder="例）info@example.com">
                                   
                                        @if ($errors->has('email'))
                                            <div class="text-danger">
                                                <span class="fa fa-exclamation form-control-feedback"></span>
                                                <span>{{ $errors->first('email') }}</span>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                                
                                <tr class="form-group">
                                	<th><label class="control-label">お問い合わせ内容</label><em>必須</em></th>
                                    <td>
                                        <textarea id="comment" class="form-control rounded-0 col-md-12{{ $errors->has('comment') ? ' is-invalid' : '' }}" name="comment" rows="20">{{ Ctm::isOld() ? old('comment') : (Session::has('contact') ? session('contact.comment') : '') }}</textarea>

                                        @if ($errors->has('comment'))
                                            <span class="text-danger">
                                            	<span class="fa fa-exclamation form-control-feedback"></span>
                                                <span>{{ $errors->first('comment') }}</span>
                                            </span>
                                        @endif
                                    </td>
                                </tr>



                            </tbody>
                		</table>
                        
                        <div class="form-group mt-5">
                            <div class="col-md-12">
                                <button type="submit"  class="btn btn-block btn-custom col-md-4 mb-4 mx-auto py-2">確認する</button>
                            </div>
                        </div>
                    </form>
                    </div>


            </div><!-- panel -->

        </div>
    </div>
@endsection
