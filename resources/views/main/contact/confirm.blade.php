@extends('layouts.app')



@section('content')
    <div class="row contact">
        <div class="col-md-12 mx-auto">
            <div class="panel panel-default">

                <div class="panel-heading">
                	<h2 class="card-header">お問い合わせ内容の確認</h2>
                    <p class="mt-3">以下の内容で送信します。<br>よろしければ「送信する」ボタンを押して下さい。</p>
                </div>

                <div class="panel-body mt-5">

					<div class="table-responsive table-normal">
                        <table class="table table-bordered bg-white">
                            
                            <tbody>
                                	
                                <tr class="form-group">
                                    <th>ご希望方法</th>
                                    <td>
                                        @if($data['is_ask_type'] == 1)
                                            お電話でのお問い合わせ
                                        @else
                                            メールでのお問い合わせ
                                        @endif
                                    </td>
                                </tr>
                                
                                <tr class="form-group">
                                    <th>お問い合わせ種別</th>
                                    <td>{{ $data['ask_category'] }}</td>
                                </tr>

                                <tr class="form-group">
                                    <th>お名前</th>
                                    <td>{{ $data['name'] }}</td>
                                </tr>

                                @if($data['is_ask_type'] == 1)
                                    <tr class="form-group">
                                        <th>電話番号</th>
                                        <td>{{ $data['tel_num'] }}</td>
                                    </tr>
                                    <tr class="form-group">
                                        <th>ご希望日</th>
                                        <td>{{ $data['request_day'] }}</td>
                                    </tr>
                                    <tr class="form-group">
                                        <th>ご希望時間帯</th>
                                        <td>{{ $data['request_time'] }}</td>
                                    </tr>
                                @endif
                                
                                <tr class="form-group">
                                    <th>メールアドレス</th>
                                    <td>{{ $data['email'] }}</td>
                                </tr>
                                
                                <tr class="form-group">
                                    <th>お問い合わせ内容</th>
                                    <td>
                                        <p>{!! nl2br($data['comment']) !!}</p>
                                    </td>
                                </tr>
                                
                            </tbody>
                		</table>
                        
                    
                     <div class="mt-5">
						<form class="form-horizontal" role="form" method="POST" action="/contact/end">
                        	{{ csrf_field() }}
                            
                            <p class="col-md-5 mx-auto d-block px-5 mb-3 text-center">
                                <b class="text-small">上記内容でよろしければ送信ボタンを押して下さい。</b>
                            </p>
                            
                            <div>
                            	<button type="submit" class="btn btn-block btn-custom col-md-4 mb-4 mx-auto py-2">送信する</button>
                        	</div> 
                        </form>

                        <a href="{{ url('contact') }}" class="btn border border-secondary bg-white mt-5"><i class="fal fa-angle-double-left"></i> 入力に戻る</a>
                    </div>

                </div>

				</div><!-- panel-body -->

            </div><!-- panel -->
            

        </div>
    </div>
@endsection
