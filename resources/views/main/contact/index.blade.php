@extends('layouts.appSingle')

@section('content')
    <div class="row contact">
        <div class="col-md-10 mx-auto py-4">
            <div class="panel panel-default">

                <div class="panel-heading">
                	<h2>お問い合わせ</h2>
                 	<p>
                  
                  	</p>      
                </div>

                <div class="panel-body">

                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Error!!</strong> 追加できません<br>
                            <ul>
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
                                	<th>お問い合わせ種別</th>
                                    <td>
                                        <select class="form-control col-md-8{{ $errors->has('ask_category') ? ' has-error' : '' }}" name="ask_category">
                                            @foreach($cate_option as $val)
                                                <option value="{{ $val }}"{{ old('ask_category') && old('ask_category') == $val ? ' selected' : '' }}>{{ $val }}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('ask_category'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('ask_category') }}</strong>
                                            </span>
                                        @endif

                                    </td>
                                </tr>


                                <tr class="form-group">
                                	<th><label class="control-label">お名前</label><em>*</em></th>
                                   	<td>
                                    	<input class="form-control col-md-12{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" placeholder="例）山田太郎">
                                   
                                        @if ($errors->has('name'))
                                            <div class="text-danger">
                                                <span class="fa fa-exclamation form-control-feedback"></span>
                                                <span>{{ $errors->first('name') }}</span>
                                            </div>
                                        @endif
                                	</td>
                                </tr>

                                <tr class="form-group">
                                	<th><label class="control-label">メールアドレス</label><em>*</em></th>
                                    <td>
                                    	<input class="form-control col-md-12{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="例）info@example.com">
                                   
                                        @if ($errors->has('email'))
                                            <div class="text-danger">
                                                <span class="fa fa-exclamation form-control-feedback"></span>
                                                <span>{{ $errors->first('email') }}</span>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                                
                                <tr class="form-group">
                                	<th><label class="control-label">お問い合わせ内容</label><em>*</em></th>
                                    <td>
                                        <textarea id="comment" class="form-control col-md-12{{ $errors->has('comment') ? ' has-error' : '' }}" name="comment" rows="20">{{ old('comment') }}</textarea>

                                        @if ($errors->has('comment'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('comment') }}</strong>
                                            </span>
                                        @endif
                                    </td>
                                </tr>



                            </tbody>
                		</table>
                        <div class="form-group">
                            <div class="col-md-3 mx-auto">
                                <button type="submit" class="btn btn-primary col-md-12">送信</button>
                            </div>
                        </div>
                    </form>
                    </div>


            </div><!-- panel -->

        </div>
    </div>
@endsection
