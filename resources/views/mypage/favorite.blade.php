@extends('layouts.app')

@section('content')


	{{-- @include('main.shared.carousel') --}}

<div id="main" class="top">

        <div class="panel panel-default">

            <div class="panel-body">
                {{-- @include('main.shared.main') --}}

				<div class="main-list clearfix">



<div class="">

<h3 class="mb-3 card-header">お気に入り一覧</h3>
<div class="table-responsive table-custom">
    <table class="table table-borderd border bg-white">
        <thead>
        <tr>
        	<th>登録日</th>
         	<th style="width: 40%;">商品名</th>
          	<th>カテゴリー</th>
           	<th>金額</th>
			<th></th>
   			<th></th>         
        </tr>
        </thead>
        
        <tbody>
        @foreach($items as $item)
        <tr>
             <td>{{ Ctm::changeDate($item->created_at, 1) }}</td>
             <td class="clearfix">
             	<a href="{{ url('item/'.$item->id) }}">
              	<img src="{{ Storage::url($item->main_img) }}" width="85" height="85" class="img-fluid float-left mr-3">  
             	{{ $item->title }}<br>
              	[{{ $item->number }}]
               </a>      
            </td>
             <td><a href="{{ url('category/'. $item->cate_id) }}">{{ $cates->find($item->cate_id)->name }}</a></td>
             <td>¥{{ number_format(Ctm::getPriceWithTax($item->price)) }}</td>
             <td>
                <a href="{{ url('item/'.$item->id) }}" class="btn border-secondary bg-white text-small">
                この商品ページへ
                </a> 
             </td>
             <td>
             	<button type="submit" class="btn btn-custom text-small">カートに入れる</button>
             </td>
        </tr>
        @endforeach
        
        </tbody>
        
	</table>
</div>

<div>
	{{ $items->links() }}
</div>

<a href="{{ url('mypage') }}" class="btn border-secondary bg-white mt-5">
<i class="fas fa-angle-double-left"></i> マイページに戻る
</a>                  

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


