@extends('layouts.appDashBoard')

@section('content')
	
	<div class="text-left">
        <h1 class="Title">
        @if(isset($edit))
        商品編集&nbsp;&nbsp;<span>ID：{{ $id }}</span>
        @else
        商品新規追加
        @endif
        </h1>
        <p class="Description"></p>
    </div>

    <div class="row">
      <div class="col-md-12 mb-5">
        <div class="bs-component clearfix">
        <div class="">
            <a href="{{ url('/dashboard/items') }}" class="btn bg-white border border-1 border-round border-secondary text-primary"><i class="fa fa-angle-double-left" aria-hidden="true"></i>一覧へ戻る</a>
        </div>
        
        @if(isset($edit))
        	<?php $linkId = $item->is_potset ? $item->pot_parent_id : $id; ?>
            <div class="mt-5 pt-3 clearfix">
            	@if(!$item->is_potset)
                    @if(Ctm::isEnv('local') || Ctm::isEnv('beta'))
                        <a href="{{ url('/dashboard/upper/'. $id. '?type=item') }}" class="btn btn-success border-round text-white d-block float-left"><i class="fa fa-angle-double-left" aria-hidden="true"></i> 上部コンテンツを編集 </a>
                    @endif
                @else
                <small>ポットセット商品：上部コンテンツ不可</small>
                @endif
                
                <a href="{{ url('/item/'. $linkId) }}" class="btn btn-warning border-round text-white d-block float-right" target="_brank">この商品のページを見る <i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
            </div>
        @endif
        
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
        <form class="form-horizontal" role="form" method="POST" action="/dashboard/items" enctype="multipart/form-data">
        
        	<div class="form-group mb-0">
                <div class="clearfix">
                    <button type="submit" class="btn btn-primary btn-block mx-auto w-btn w-25">更　新</button>
                </div>
                @if(isset($item))
                	<b class="text-big">ID：{{ $item->id }}</b>
                @endif
            </div>

            {{ csrf_field() }}
            
            @if(isset($edit))
                <input type="hidden" name="edit_id" value="{{ $id }}">
            @endif

			<div class="form-group">
                <div class="col-md-12 text-right mb-3 pb-3 mt-0">
                    <div class="checkbox">
                        <label>
                            <?php
                                $checked = '';
                                if(Ctm::isOld()) {
                                    if(old('open_status'))
                                        $checked = ' checked';
                                }
                                else {
                                    if(isset($item) && ! $item->open_status) {
                                        $checked = ' checked';
                                    }
                                }
                            ?>
                            <input type="checkbox" name="open_status" value="1"{{ $checked }}> この商品を非公開にする
                        </label>
                    </div>
                </div>
            </div>
        
        <span class="text-small text-secondary d-block mb-3">＊UPする画像のファイル名は全て半角英数字とハイフンのみで構成して下さい。(abc-123.jpg など)</span>
        <hr>
	
    	
		<div class="form-group clearfix mb-4 thumb-wrap">
        	<fieldset class="w-25 float-right">
                <div class="col-md-12 checkbox text-right px-0">
                    <label>
                        <?php
                            $checked = '';
                            if(Ctm::isOld()) {
                                if(old('del_mainimg'))
                                    $checked = ' checked';
                            }
                            else {
                                if(isset($item) && $item->del_mainimg) {
                                    $checked = ' checked';
                                }
                            }
                        ?>

                        <input type="hidden" name="del_mainimg" value="0">
                        <input type="checkbox" name="del_mainimg" value="1"{{ $checked }}> この画像を削除
                    </label>
                </div>
            </fieldset>
            
            <fieldset>
                <div class="float-left col-md-4 px-0 thumb-prev">
                    @if(count(old()) > 0)
                        @if(old('main_img') != '' && old('main_img'))
                        <img src="{{ Storage::url(old('main_img')) }}" class="img-fluid">
                        @elseif(isset($item) && $item->main_img)
                        <img src="{{ Storage::url($item->main_img) }}" class="img-fluid">
                        @else
                        <span class="no-img">No Image</span>
                        @endif
                    @elseif(isset($item) && $item->main_img)
                    <img src="{{ Storage::url($item->main_img) }}" class="img-fluid">
                    @else
                    <span class="no-img">No Image</span>
                    @endif
                </div>
                

                <div class="float-left col-md-8 pl-3 pr-0">
                    <fieldset class="form-group{{ $errors->has('main_img') ? ' is-invalid' : '' }}">
                        <label for="main_img">メイン画像</label>
                        <input class="form-control-file thumb-file" id="main_img" type="file" name="main_img">
                    </fieldset>
                
                    @if ($errors->has('main_img'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('main_img') }}</strong>
                        </span>
                    @endif
                    
                    <span class="text-small text-secondary">＊メイン画像は原則必要なものとなります。<br>削除後の未入力など注意して下さい。</span>
                
                </div>
            </fieldset>
            
            <input class="form-control mt-3 col-md-12{{ $errors->has('main_caption') ? ' is-invalid' : '' }}" name="main_caption" value="{{ Ctm::isOld() ? old('main_caption') : (isset($item) ? $item->main_caption : '') }}" placeholder="メインキャプション">

                @if ($errors->has('main_caption'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('main_caption') }}</span>
                    </div>
                @endif
        </div>
        
        {{--
        <div class="form-group clearfix">
            @for($i=0; $i< 10; $i++)
                @include('dashboard.item.img')
            @endfor
    	</div>
     	--}}
                    
  		<div class="clearfix mb-3">
            <hr class="my-4">
            <?php
                $s=0;
                //use App\Setting;
                //$subSetCount = 10;
                //$setCount = Setting::get()->first()->snap_count;
            ?>
            @while($s < $primaryCount)
                <div class="clearfix spare-img thumb-wrap">

                    <fieldset class="w-25 float-right">
                        <div class="checkbox text-right px-0">
                            <label>
                                <?php
                                    $checked = '';
                                    if(Ctm::isOld()) {
                                        if(old('del_spare.'.$s))
                                            $checked = ' checked';
                                    }
                                    else {
                                        if(isset($item) && $item->del_spare) {
                                            $checked = ' checked';
                                        }
                                    }
                                ?>

                                <input type="hidden" name="del_spare[{{$s}}]" value="0">
                                <input type="checkbox" name="del_spare[{{$s}}]" value="1"{{ $checked }}> この画像を削除
                            </label>
                        </div>
                    </fieldset>
                    
                    <fieldset class="float-left w-75 clearfix">
                        <div class="w-25 float-left thumb-prev">
                            @if(count(old()) > 0)
                                @if(old('spare_thumb.'.$s) != '' && old('spare_thumb.'.$s))
                                <img src="{{ Storage::url(old('spare_thumb.'.$s)) }}" class="img-fluid">
                                @elseif(isset($spares[$s]) && $spares[$s]->img_path)
                                <img src="{{ Storage::url($spares[$s]->img_path) }}" class="img-fluid">
                                @else
                                <span class="no-img">No Image</span>
                                @endif
                            @elseif(isset($spares[$s]) && $spares[$s]->img_path)
                                <img src="{{ Storage::url($spares[$s]->img_path) }}" class="img-fluid">
                            @else
                                <span class="no-img">No Image</span>
                            @endif
                        </div>

                        <div class="col-md-8 pull-left text-left form-group{{ $errors->has('spare_thumb.'.$s) ? ' is-invalid' : '' }}">
                            <label for="model_thumb" class="col-md-12 text-left">サブ画像 <span class="text-primary">{{ $s+1 }}</spa></label>
                            <div class="w-100">
                                <input id="model_thumb" class="thumb-file" type="file" name="spare_thumb[]">

                                @if ($errors->has('spare_thumb.'.$s))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('spare_thumb.'.$s) }}</strong>
                                    </span>
                                @endif

                            </div>
                        </div>
                    </fieldset>
                </div>
                
                <fieldset>
                    <input class="form-control mt-2{{ $errors->has('caption.'.$s) ? ' is-invalid' : '' }}" name="caption[]" value="{{ Ctm::isOld() ? old('caption.'.$s) : (isset($spares[$s]) ? $spares[$s]->caption : '') }}" placeholder="キャプション{{ $s+1 }}">

                    @if ($errors->has('caption.'.$s))
                        <div class="text-danger">
                            <span class="fa fa-exclamation form-control-feedback"></span>
                            <span>{{ $errors->first('caption.'.$s) }}</span>
                        </div>
                    @endif
                </fieldset>
                
                
                <hr class="my-4">

                <input type="hidden" name="spare_count[]" value="{{ $s }}">

                <?php $s++; ?>
            @endwhile


        </div>
            
            
        
			<fieldset class="mt-5 mb-4 form-group">
                <label>商品番号 <span class="text-danger text-big">*</span> （半角英数字とハイフンのみで構成して下さい）</label>
                <input class="form-control{{ $errors->has('number') ? ' is-invalid' : '' }}" name="number" value="{{ Ctm::isOld() ? old('number') : (isset($item) ? $item->number : '') }}">

                @if ($errors->has('number'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('number') }}</span>
                    </div>
                @endif
            </fieldset>
            
            <fieldset class="mb-4 form-group">
                <label>商品名 <span class="text-danger text-big">*</span></label>
                <input class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ Ctm::isOld() ? old('title') : (isset($item) ? $item->title : '') }}">

                @if ($errors->has('title'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('title') }}</span>
                    </div>
                @endif
            </fieldset>
            
            <fieldset class="mb-4 form-group">
                <label>商品名補足（商品名の上部に表示）</label>
                <input class="form-control{{ $errors->has('title_addition') ? ' is-invalid' : '' }}" name="title_addition" value="{{ Ctm::isOld() ? old('title_addition') : (isset($item) ? $item->title_addition : '') }}" placeholder="常緑 つる性 など">

                @if ($errors->has('title_addition'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('title_addition') }}</span>
                    </div>
                @endif
            </fieldset>
            
            <fieldset class="mb-5 form-group">
                <label>キャッチコピー</label>
                <input class="form-control{{ $errors->has('catchcopy') ? ' is-invalid' : '' }}" name="catchcopy" value="{{ Ctm::isOld() ? old('catchcopy') : (isset($item) ? $item->catchcopy : '') }}" placeholder="商品番号の下に表示される">

                @if ($errors->has('catchcopy'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('catchcopy') }}</span>
                    </div>
                @endif
            </fieldset>
            
            <fieldset class="form-group mb-2 pb-1">
                <div class="checkbox">
                    <label>
                        <?php
                            $checked = '';
                            if(Ctm::isOld()) {
                                if(old('is_ensure'))
                                    $checked = ' checked';
                            }
                            else {
                                if(isset($item) && $item->is_ensure) {
                                    $checked = ' checked';
                                }
                            }
                        ?>
                        <input type="checkbox" name="is_ensure" value="1"{{ $checked }}> 枯れ保証あり
                    </label>
                </div>
            </fieldset>
            
            <fieldset class="mt-1 mb-5 form-group">
                <label>商品タイプ</label>
                <select class="form-control col-md-6{{ $errors->has('item_type') ? ' is-invalid' : '' }}" name="item_type">
                	<?php
                    	$itemTypes = ['植木'=>1, 'ポット苗'=>2, '資材'=>3];
                    ?>
                    <option selected>選択して下さい</option>
                    @foreach($itemTypes as $key => $itemTypeNum)
                        <?php
                            $selected = '';
                            if(Ctm::isOld()) {
                                if(old('item_type') == $itemTypeNum)
                                    $selected = ' selected';
                            }
                            else {
                                if(isset($item) && $item->item_type == $itemTypeNum) {
                                    $selected = ' selected';
                                }
                            }
                        ?>
                        <option value="{{ $itemTypeNum }}"{{ $selected }}>{{ $key }}</option>
                    @endforeach
                </select>
                
                @if ($errors->has('consignor_id'))
                    <span class="help-block text-warning">
                        <strong>{{ $errors->first('consignor_id') }}</strong>
                    </span>
                @endif   
            </fieldset>
            
            
            <fieldset class="form-group mb-2 mt-3">
                    <div class="checkbox">
                        <label>
                            <?php
                                $checked = '';
                                if(Ctm::isOld()) {
                                    if(old('is_potset'))
                                        $checked = ' checked';
                                }
                                else {
                                    if(isset($item) && $item->is_potset) {
                                        $checked = ' checked';
                                    }
                                }
                            ?>
                            <input type="checkbox" name="is_potset" value="1"{{ $checked }}> ポットセットにする
                        </label>
                    </div>
            </fieldset>
            
            <fieldset class="mb-2 form-group">
                <label for="pot_parent_id" class="control-label">ポットセット親ID</label>
                <input class="form-control col-md-6{{ $errors->has('pot_parent_id') ? ' is-invalid' : '' }}" name="pot_parent_id" value="{{ Ctm::isOld() ? old('pot_parent_id') : (isset($item) ? $item->pot_parent_id : '') }}">
                

                @if ($errors->has('pot_parent_id'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('pot_parent_id') }}</span>
                    </div>
                @endif
            </fieldset>
            
            <fieldset class="mb-5 form-group">
                <label for="pot_count" class="control-label">ポット数</label>
                <input class="form-control col-md-6{{ $errors->has('pot_count') ? ' is-invalid' : '' }}" name="pot_count" value="{{ Ctm::isOld() ? old('pot_count') : (isset($item) ? $item->pot_count : '') }}">
                

                @if ($errors->has('pot_count'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('pot_count') }}</span>
                    </div>
                @endif
            </fieldset>

            
            
            <fieldset class="mb-4 form-group">
            	
                <label>親カテゴリー <span class="text-danger text-big cate-require">*</span></label>
                <select class="form-control select-first col-md-6{{ $errors->has('cate_id') ? ' is-invalid' : '' }}" name="cate_id">
                    <option disabled selected>選択して下さい</option>
                    @foreach($cates as $cate)
                        <?php
                            $selected = '';
                            if(Ctm::isOld()) {
                                if(old('cate_id') == $cate->id)
                                    $selected = ' selected';
                            }
                            else {
                                if(isset($item) && $item->cate_id == $cate->id) {
                                    $selected = ' selected';
                                }
                            }
                        ?>
                        <option value="{{ $cate->id }}"{{ $selected }}>{{ $cate->name }}</option>
                    @endforeach
                </select>
                <span class="text-warning"></span>
                
                @if ($errors->has('cate_id'))
                    <div class="help-block text-danger">
                    	<span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('cate_id') }}</span>
                    </div>
                @endif
                
            </fieldset>
            
            <fieldset class="mb-4 form-group">
                <label>子カテゴリー</label>
                <select class="form-control select-second col-md-6{{ $errors->has('subcate_id') ? ' is-invalid' : '' }}" name="subcate_id">
                    
                    @if(isset($subcates))
                    	<option disabled selected>選択して下さい</option>
                        @foreach($subcates as $subcate)
                            <?php
                                $selected = '';
                                if(Ctm::isOld()) {
                                    if(old('subcate_id') == $subcate->id)
                                        $selected = ' selected';
                                }
                                else {
                                    if(isset($item) && $item->subcate_id == $subcate->id) {
                                        $selected = ' selected';
                                    }
                                }
                            ?>
                            <option value="{{ $subcate->id }}"{{ $selected }}>{{ $subcate->name }}</option>
                        @endforeach
                    @else
                    	<option disabled selected>親カテゴリーを選択して下さい</option>
                    @endif
                </select>
                
                @if ($errors->has('subcate_id'))
                    <div class="help-block text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('subcate_id') }}</span>
                    </div>
                @endif
                
            </fieldset>
            
            
            <fieldset class="mb-4 form-group">
                <label for="price" class="control-label">価格（本体価格）<span class="text-danger text-big">*</span><small>（ポット親の時は1を入力）</small></label>
                <input class="form-control col-md-6{{ $errors->has('price') ? ' is-invalid' : '' }}" name="price" value="{{ Ctm::isOld() ? old('price') : (isset($item) ? $item->price : '') }}" placeholder="税抜き金額を入力">
                
                @if ($errors->has('price'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('price') }}</span>
                    </div>
                @endif
            </fieldset>
            
            <fieldset class="mb-4 form-group">
                <label for="cost_price" class="control-label">仕入れ値</label>
                <input class="form-control col-md-6{{ $errors->has('cost_price') ? ' is-invalid' : '' }}" name="cost_price" value="{{ Ctm::isOld() ? old('cost_price') : (isset($item) ? $item->cost_price : '') }}">
                

                @if ($errors->has('cost_price'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('cost_price') }}</span>
                    </div>
                @endif
            </fieldset>
            
            <fieldset class="mb-4 form-group">
                <label for="sale_price" class="control-label">セール価格<span><small>（ポット親でSaleにしたい時は1を入力）</small></label>
                <input class="form-control col-md-6{{ $errors->has('sale_price') ? ' is-invalid' : '' }}" name="sale_price" value="{{ Ctm::isOld() ? old('sale_price') : (isset($item) ? $item->sale_price : '') }}">
                

                @if ($errors->has('sale_price'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('sale_price') }}</span>
                    </div>
                @endif
            </fieldset>
            
            
            
            <fieldset class="mt-5 mb-4 form-group">
                <label>出荷元</label>
                <select class="form-control col-md-6{{ $errors->has('consignor_id') ? ' is-invalid' : '' }}" name="consignor_id">
                    <option selected>選択して下さい</option>
                    @foreach($consignors as $consignor)
                        <?php
                            $selected = '';
                            if(Ctm::isOld()) {
                                if(old('consignor_id') == $consignor->id)
                                    $selected = ' selected';
                            }
                            else {
                                if(isset($item) && $item->consignor_id == $consignor->id) {
                                    $selected = ' selected';
                                }
                            }
                        ?>
                        <option value="{{ $consignor->id }}"{{ $selected }}>{{ $consignor->name }}</option>
                    @endforeach
                </select>
                
                @if ($errors->has('consignor_id'))
                    <span class="help-block text-warning">
                        <strong>{{ $errors->first('consignor_id') }}</strong>
                    </span>
                @endif
                
            </fieldset>
            
            <fieldset class="mb-3 form-group">
                <label>配送区分 <span class="text-danger text-big">*</span></label>
                <select class="form-control col-md-6{{ $errors->has('dg_id') ? ' is-invalid' : '' }}" name="dg_id">
                    <option disabled selected>選択して下さい</option>
                    @foreach($dgs as $dg)
                        <?php
                            $selected = '';
                            if(Ctm::isOld()) {
                                if(old('dg_id') == $dg->id)
                                    $selected = ' selected';
                            }
                            else {
                                if(isset($item) && $item->dg_id == $dg->id) {
                                    $selected = ' selected';
                                }
                            }
                        ?>
                        <option value="{{ $dg->id }}"{{ $selected }}>{{ $dg->name }}</option>
                    @endforeach
                </select>
                <span class="text-warning"></span>
                
                @if ($errors->has('dg_id'))
                    <div class="help-block text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('dg_id') }}</span>
                    </div>
                @endif
                
            </fieldset>
            
            <fieldset class="mb-4 form-group">
                <label for="factor" class="control-label">係数 <span class="text-danger text-big">*</span></label>
                <input class="form-control col-md-6{{ $errors->has('factor') ? ' is-invalid' : '' }}" name="factor" value="{{ Ctm::isOld() ? old('factor') : (isset($item) ? $item->factor : '') }}" placeholder="">
                
                @if ($errors->has('factor'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('factor') }}</span>
                    </div>
                @endif
            </fieldset>
            
            
            <fieldset class="form-group mb-2">
                    <div class="checkbox">
                        <label>
                            <?php
                                $checked = '';
                                if(Ctm::isOld()) {
                                    if(old('is_delifee'))
                                        $checked = ' checked';
                                }
                                else {
                                    if(isset($item) && $item->is_delifee) {
                                        $checked = ' checked';
                                    }
                                }
                            ?>
                            <input type="checkbox" name="is_delifee" value="1"{{ $checked }}> 送料を無料にする
                        </label>
                    </div>
            </fieldset>
            
            <fieldset class="form-group mb-2">
                    <div class="checkbox">
                        <label>
                            <?php
                                $checked = '';
                                if(Ctm::isOld()) {
                                    if(old('is_once'))
                                        $checked = ' checked';
                                }
                                else {
                                    if(isset($item) && $item->is_once) {
                                        $checked = ' checked';
                                    }
                                }
                            ?>
                            <input type="checkbox" name="is_once" value="1"{{ $checked }}> 同梱包可能
                        </label>
                    </div>
            </fieldset>
            
            <fieldset class="form-group mb-3">
                    <div class="checkbox">
                        <label>
                            <?php
                                $checked = '';
                                if(Ctm::isOld()) {
                                    if(old('is_once_recom'))
                                        $checked = ' checked';
                                }
                                else {
                                    if(isset($item) && $item->is_once_recom) {
                                        $checked = ' checked';
                                    }
                                }
                            ?>
                            <input type="checkbox" name="is_once_recom" value="1"{{ $checked }}> 同梱包可能おすすめに表示させない
                        </label>
                    </div>
            </fieldset>
            
            <fieldset class="mb-5 form-group">
                <label for="deli_plan_text" class="control-label">発送目安テキスト</label>
                <input class="form-control col-md-12{{ $errors->has('deli_plan_text') ? ' is-invalid' : '' }}" name="deli_plan_text" value="{{ Ctm::isOld() ? old('deli_plan_text') : (isset($item) ? $item->deli_plan_text : '') }}">
                

                @if ($errors->has('deli_plan_text'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('deli_plan_text') }}</span>
                    </div>
                @endif
            </fieldset>
            

            <fieldset class="mt-5 mb-2 form-group">
                <label>代金引換設定</label>
                <select class="form-control col-md-6{{ $errors->has('cod') ? ' is-invalid' : '' }}" name="cod">
                    <option disabled selected>選択して下さい</option>
                        <?php
                        	$cods = [ 1 =>'可', 0 =>'不可'];
                        ?>
                    @foreach($cods as $key => $cod)
                        <?php
                            $selected = '';
                            if(Ctm::isOld()) {
                                if(old('cod') == $key)
                                    $selected = ' selected';
                            }
                            else {
                                if(isset($item) && $item->cod == $key) {
                                    $selected = ' selected';
                                }
                            }
                        ?>
                        <option value="{{ $key }}"{{ $selected }}>{{ $cod }}</option>
                    @endforeach
                </select>
                
                @if ($errors->has('cod'))
                    <span class="help-block text-warning">
                        <strong>{{ $errors->first('cod') }}</strong>
                    </span>
                @endif
                
            </fieldset>
            
            <fieldset class="form-group mb-4">
                    <div class="checkbox">
                        <label>
                            <?php
                                $checked = '';
                                if(Ctm::isOld()) {
                                    if(old('farm_direct'))
                                        $checked = ' checked';
                                }
                                else {
                                    if(isset($item) && $item->farm_direct) {
                                        $checked = ' checked';
                                    }
                                }
                            ?>
                            <input type="checkbox" name="farm_direct" value="1"{{ $checked }}> 産地直送
                        </label>
                    </div>
            </fieldset>
            
            <fieldset class="mb-2 form-group">
                <label for="stock" class="control-label">在庫数</label>
                <input class="form-control col-md-6{{ $errors->has('stock') ? ' is-invalid' : '' }}" name="stock" value="{{ Ctm::isOld() ? old('stock') : (isset($item) ? $item->stock : '') }}">
                

                @if ($errors->has('stock'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('stock') }}</span>
                    </div>
                @endif
            </fieldset>
            
            <fieldset class="form-group mb-4">
                    <div class="checkbox">
                        <label>
                            <?php
                                $checked = '';
                                if(Ctm::isOld()) {
                                    if(old('stock_show'))
                                        $checked = ' checked';
                                }
                                else {
                                    if(isset($item) && $item->stock_show) {
                                        $checked = ' checked';
                                    }
                                }
                            ?>
                            <input type="checkbox" name="stock_show" value="1"{{ $checked }}> 在庫数を表示する
                        </label>
                    </div>
            </fieldset>
            
            
            <fieldset class="mb-3 form-group">
                <label>売り切れ表示設定</label>
                <select class="form-control col-md-6{{ $errors->has('stock_type') ? ' is-invalid' : '' }}" name="stock_type">
                    <option value="0" selected>選択して下さい</option>
                        <?php
                        	$stocks = [ 1 =>'次回[-]月頃入荷予定', 2 =>'次回入荷未定'];
                        ?>
                        
                        @foreach($stocks as $key => $val)
                            <?php
                                $selected = '';
                                if(Ctm::isOld()) {
                                    if(old('stock_type') == $key)
                                        $selected = ' selected';
                                }
                                else {
                                    if(isset($item) && $item->stock_type == $key) {
                                        $selected = ' selected';
                                    }
                                }
                            ?>
                            <option value="{{ $key }}"{{ $selected }}>{{ $val }}</option>
                        @endforeach
                </select>
                
                @if ($errors->has('stock_type'))
                    <span class="help-block text-warning">
                        <strong>{{ $errors->first('stock_type') }}</strong>
                    </span>
                @endif
                
            </fieldset>
            
            <fieldset class="mb-2 form-group">
                <label for="stock" class="control-label">在庫入荷月 {{--<span class="text-danger text-big">*</span><small>（売り切れ表示で「[-]月頃入荷予定」の選択時のみ）</small>--}}</label>
                <input class="form-control col-md-6{{ $errors->has('stock_reset_month') ? ' is-invalid' : '' }}" name="stock_reset_month" value="{{ Ctm::isOld() ? old('stock_reset_month') : (isset($item) ? $item->stock_reset_month : '') }}">
                

                @if ($errors->has('stock_reset_month'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('stock_reset_month') }}</span>
                    </div>
                @endif
            </fieldset>
            
            <fieldset class="mb-5 form-group">
                <label for="stock" class="control-label">在庫リセット数</label>
                <input class="form-control col-md-6{{ $errors->has('stock_reset_count') ? ' is-invalid' : '' }}" name="stock_reset_count" value="{{ Ctm::isOld() ? old('stock_reset_count') : (isset($item) ? $item->stock_reset_count : '') }}">
                

                @if ($errors->has('stock_reset_count'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('stock_reset_count') }}</span>
                    </div>
                @endif
            </fieldset>
            
            <fieldset class="mb-5 form-group">
                <label for="point_back" class="control-label">ポイント還元率（%）</label>
                <input class="form-control col-md-6{{ $errors->has('point_back') ? ' is-invalid' : '' }}" name="point_back" value="{{ Ctm::isOld() ? old('point_back') : (isset($item) ? $item->point_back : '') }}">
                

                @if ($errors->has('point_back'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('point_back') }}</span>
                    </div>
                @endif
            </fieldset>
            
            
            <label>アイコンを表示</label>
            <?php
                $ii = 0;
            ?>
            @foreach($icons as $icon)
                <fieldset class="form-group mb-2 pl-3">
                    <div class="checkbox">
                        
                        <label>
                            <?php
                                $checked = '';
                                if(Ctm::isOld() && old('icons')) {
                                    if(in_array($icon->id, old('icons')))
                                        $checked = ' checked';
                                }
                                else {
                                    if(isset($item) && in_array($icon->id, explode(',', $item->icon_id))) {
                                        $checked = ' checked';
                                    }
                                }
                            ?>
                            
                            <input type="checkbox" name="icons[]" value="{{ $icon->id }}"{{ $checked }}> {{ $icon->title }}
                        </label>
                    </div>
                </fieldset>
                
                <?php $ii++; ?>
            @endforeach
            
            
            
            
            <div class="clearfix tag-wrap">
                <div class="tag-group form-group{{ $errors->has('tag-group') ? ' is-invalid' : '' }}">
                    <label for="tag-group" class="control-label">タグ</label>
                    <div class="clearfix">
                        <input id="tag-group" type="text" class="form-control col-md-5 tag-control" name="input-tag-group" value="" autocomplete="off" placeholder="Enter tag">

                        <div class="add-btn" tabindex="0">追加</div>

                        <span style="display:none;">{{ implode(',', $allTags) }}</span>

                        <div class="tag-area">
                            @if(count(old()) > 0)
                                <?php
                                    //$tagNames = old($tag->slug);
                                    $tagNames = old('tags');
                                ?>
                            @endif

                            @if(isset($tagNames))
                                @foreach($tagNames as $name)
                                <span><em>{{ $name }}</em><i class="fa fa-times del-tag" aria-hidden="true"></i></span>
                                <input type="hidden" name="tags[]" value="{{ $name }}">
                                @endforeach
                            @endif

                        </div>

                    </div>

                </div>

            </div><?php //tagwrap ?>
            
            
            <div class="form-group mb-5 mr-3">
                <div class="clearfix">
                    <button type="submit" class="btn btn-primary btn-block mx-auto w-btn w-25 float-right">更　新</button>
                </div>
            </div>

            
            <fieldset class="my-5 form-group{{ $errors->has('exp_first') ? ' is-invalid' : '' }}">
                    <label for="explain" class="control-label">キャッチ説明（商品ヘッドの中に表示）</label>

                    <textarea class="form-control" name="exp_first" rows="10">{{ Ctm::isOld() ? old('exp_first') : (isset($item) ? $item->exp_first : '') }}</textarea>

                    @if ($errors->has('exp_first'))
                        <span class="help-block">
                            <strong>{{ $errors->first('exp_first') }}</strong>
                        </span>
                    @endif
            </fieldset>
            
            <fieldset class="my-5 form-group{{ $errors->has('explain') ? ' is-invalid' : '' }}">
                    <label for="explain" class="control-label">商品詳細</label>

                    <textarea class="form-control" name="explain" rows="20">{{ Ctm::isOld() ? old('explain') : (isset($item) ? $item->explain : '') }}</textarea>

                    @if ($errors->has('explain'))
                        <span class="help-block">
                            <strong>{{ $errors->first('explain') }}</strong>
                        </span>
                    @endif
            </fieldset>
            
            
            <fieldset class="mt-3 mb-2 form-group{{ $errors->has('about_ship') ? ' is-invalid' : '' }}">
                    <label for="detail" class="control-label">配送について</label>

                        <textarea class="form-control" name="about_ship" rows="20">{{ Ctm::isOld() ? old('about_ship') : (isset($item) ? $item->about_ship : '') }}</textarea>

                        @if ($errors->has('about_ship'))
                            <span class="help-block">
                                <strong>{{ $errors->first('about_ship') }}</strong>
                            </span>
                        @endif
            </fieldset>
            
            <fieldset class="form-group mt-3 mb-5">
                <div class="checkbox">
                    <label>
                        <?php
                            $checked = '';
                            if(Ctm::isOld()) {
                                if(old('is_delifee_table'))
                                    $checked = ' checked';
                            }
                            else {
                                if(isset($item) && $item->is_delifee_table) {
                                    $checked = ' checked';
                                }
                            }
                        ?>
                        <input type="checkbox" name="is_delifee_table" value="1"{{ $checked }}> 送料表を表示する
                    </label>
                </div>
            </fieldset>
            
            <?php
                $obj = null;
                if(isset($item)) $obj = $item;
            ?>

            @include('dashboard.shared.contents')
            
            
            <fieldset class="mt-3 mb-2 form-group{{ $errors->has('caution') ? ' is-invalid' : '' }}">
                <label for="caution" class="control-label">ご注意</label>

                <textarea class="form-control" name="caution" rows="20">{{ Ctm::isOld() ? old('caution') : (isset($item) ? $item->caution : '') }}</textarea>

                @if ($errors->has('caution'))
                    <span class="help-block">
                        <strong>{{ $errors->first('caution') }}</strong>
                    </span>
                @endif
            </fieldset>
            
            
            <div class="form-group mt-3 pt-3 mb-5 pb-5">
                <button type="submit" class="btn btn-primary btn-block w-btn w-25 mx-auto">更　新</button>
            </div>
            
            
            {{--
            <fieldset class="mt-3 mb-2 form-group{{ $errors->has('free_space') ? ' is-invalid' : '' }}">
                <label for="detail" class="control-label">フリースペース（ページ上部）</label>

                <textarea id="detail" type="text" class="form-control" name="free_space" rows="20">{{ Ctm::isOld() ? old('free_space') : (isset($item) ? $item->free_space : '') }}</textarea>

                @if ($errors->has('free_space'))
                    <span class="help-block">
                        <strong>{{ $errors->first('free_space') }}</strong>
                    </span>
                @endif
        	</fieldset>
            

            <div class="form-group mt-3 pt-3 mb-5 pb-5">
                <button type="submit" class="btn btn-primary btn-block w-btn w-25 mx-auto">更　新</button>
            </div>
			--}}
			
            @include('dashboard.shared.meta')
            
            <div class="form-group mt-5 pt-3">
                <button type="submit" class="btn btn-primary btn-block w-btn w-25 mx-auto">更　新</button>
            </div>
            

        </form>

    </div>

    

@endsection
