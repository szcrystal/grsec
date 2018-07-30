@extends('layouts.app')

@section('content')
    <div class="row contact">
        <div class="col-md-12 mx-auto">
            <div class="panel panel-default">

                <div class="panel-heading">
                	<h2 class="card-header">お問い合わせ内容の確認</h2>
                </div>

                <div class="panel-body mt-5">

					<div class="table-responsive">
                        <table class="table table-bordered table-custom">
                            <colgroup>
                                <col style="width:28%;" class="cth">
                                <col class="ctd bg-white">
                            </colgroup>
                            
                            <tbody>
                                <tr class="form-group">
                                	<th>お問い合わせ種別</th>
                                    <td>
                                    	{{ $data['ask_category'] }}
                                    </td>
                                </tr>


                                <tr class="form-group">
                                	<th><label class="control-label">お名前</label</th>
                                   	<td>
                                    	{{ $data['name'] }}
                                    	
                                	</td>
                                </tr>

                                <tr class="form-group">
                                	<th><label class="control-label">メールアドレス</label></th>
                                    <td>
                                    	{{ $data['email'] }}
                                    	
                                    </td>
                                </tr>
                                
                                <tr class="form-group">
                                	<th><label class="control-label">お問い合わせ内容</label></th>
                                    <td>
                                    	<p>
                                    	{!! nl2br($data['comment']) !!}
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                		</table>
                        
                    
                     <div class="mt-5">
						<form class="form-horizontal" role="form" method="POST" action="/contact/end">
                            {{ csrf_field() }}
                            
                            <?php //print_r($itemData); ?>
                            
                            <input type="hidden" name="done_status" value="0">
                            
                            
                          <small class="col-md-5 mx-auto d-block px-5 mb-3">
                          <b>上記内容でよろしければ送信ボタンを押して下さい。</b>
                          </small>
                          
                          <div class="col-md-12">
                            <button class="btn btn-block btn-custom col-md-4 mb-4 mx-auto py-2" type="submit" name="regist_off" value="1">送信する</button>
                            </div>                
                        </form>

                        <a href="{{ url('contact') }}" class="btn border border-secondary bg-white mt-5"><i class="fas fa-angle-double-left"></i> 入力に戻る</a>
                    </div>

                </div>


            </div><!-- panel -->
            

        </div>
    </div>
@endsection
