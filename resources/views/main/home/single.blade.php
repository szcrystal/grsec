@extends('layouts.app')

@section('content')

<?php
use App\User;

?>

    <div class="single">

            <div class="head-frame clearfix">
                <div class="float-left col-md-7">
                @if($item -> main_img)
                	<img src="{{ Storage::url($item->main_img) }}" alt="{{ $item->title }}" class="img-fluid">
                 @else
                 	<span class="no-img">No Image</span>
                 @endif   
                </div>
                
                <div class="float-right col-md-5">
                	<h2>{{ $item -> title }}</h2>
                 	
                  	<?php
                   	$per = env('TAX_PER');
                    $per = $per/100;
                    
                    $tax = floor($item->price * $per);
                    $price = $item->price + $tax;
                   	
                   ?>      
                    
                 	<dic class="price-meta">
                  	   価格 {{ number_format($price) }}円　(内税:{{ number_format($tax) }}円)
                    </div>	
                    
                    <p>{{ $item->detail }}</p>
                  
                  	<div>
                   		<form method="post" action="{{ url('cart') }}">
                     		{{ csrf_field() }}
                                   
                     		<input type="hidden" name="item_id" value="{{ $item->id }}">      
                     		<input type="hidden" name="price" value="{{ $item->price }}">
                       		<input type="hidden" name="tax" value="{{ $tax }}">      
                       		<input type="hidden" name="count" value="1">           
                  	  		<button type="submit" class="btn btn-warning">カートに入れる</button>
                       </form>                                 
                	</div>
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
                            
                            <tbody>

                                

                                <tr>
                                    <th>カテゴリー</th>
                                    <td>
                                    @if($cateObj)
                                    	<span class="rank-tag">
                                    		{{ $cateObj->find($item->cate_id)->name }}
                                        </span>
                                    @endif
                                    </td>
                                </tr>
                                
                                <tr>
                                    <th>タグ</th>
                                    <td>
                                        @foreach($tags as $tag)
                                            <span class="rank-tag">
                                            <i class="fa fa-tag" aria-hidden="true"></i>
                                            <a href="{{ url('tag/' . $tag->slug) }}">{{ $tag->name }}</a>
                                            </span>
                                        @endforeach

                                    </td>
                                </tr>

                                <tr>
                                    <th>A</th>
                                    <td><span class="rank-tag"></span></td>
                                </tr>
                                
                                <tr>
									{{--
									<th>作成</th>
									<td>{{ User::find($item->model_id)->name }}</td>
                                    --}}

                                    <th>C</th>
                                        
                                        <td>
                                            <span class="rank-tag">
                                            <i class="fa fa-user" aria-hidden="true"></i>
                                            </td>
                                            </span>
                                </tr>


                            </tbody>
                		</table>
                    </div>

                    
                    <div class="mt-4">
                    	{{ $item->title}} とは
                    	<p>{!! nl2br($item->what_is) !!}</p>
                    </div>
                    
                    <div class="mt-4">
                    	{!! nl2br($item->warning) !!}
                    </div>
					


                	</div>


				</div><!-- panelbody -->

    </div>
@endsection
