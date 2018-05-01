@extends('layouts.app')

@section('content')

<?php
use App\User;

?>

    <div class="single">

            <div class="head-frame clearfix">
            
                
            </div>


            <div class="col-md-12 panel-body">

                <div class="cont-wrap">
                	

                    <div class="clear contents">


                    </div>

                    <div class="map-wrap">

                    </div>

                    <div class="table-responsive py-3 mt-4">
                    	<table class="table table-bordered table-striped">
                            <colgroup>
                                <col class="cth">
                                <col class="ctd">
                            </colgroup>
                            
                            <thead>
                            	<tr>
                             		<th></th>   
                             		<th>商品名</th>
                               		<th>価格</th> 
                                 	<th>数量</th>           
                                </tr>
                            </thead>
                            <tbody>

                                
								<tr>
        							<td><img src="{{ Storage::url($buyItem->main_img) }}" width="80" height="80"></td>
                            
                                    
                                    <td>{{ $buyItem ->title }}</td>
                                    
                                    <td>{{ number_format($buyItem->price + $tax) }}</td>
                                
                                    <td>{{ $count }} <br><a href="#">削除する</a></td>
                                </tr>
                                


                            </tbody>
                            
                            <tfoot>
                            	<tr></tr>
                            </tfoot>
                		</table>
                  
                  		<p class="text-bold">小計：{{ number_format($count * ($buyItem->price + $tax) ) }} 円</p>      
                    </div>

                    
					<a href="{{ url('cart/thankyou') }}" class="btn btn-warning">購入する<!-- レジに進む --></a>


                	</div>


				</div><!-- panelbody -->

    </div>
@endsection
