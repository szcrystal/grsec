@extends('layouts.appDashBoard')

@section('content')
	
	<div class="text-left">
        <h1 class="Title">
        @if(isset($edit))
        サイト設定編集
        @else
        サイト設定編集
        @endif
        </h1>
        <p class="Description"></p>
    </div>

{{--
    <div class="row">
      <div class="col-sm-12 col-md-6 col-lg-6 col-xl-5 mb-5">
        <div class="bs-component clearfix">
        <div class="pull-left">
            <a href="{{ url('/dashboard/consignors') }}" class="btn bg-white border border-1 border-round border-secondary text-primary"><i class="fa fa-angle-double-left" aria-hidden="true"></i>一覧へ戻る</a>
        </div>
    	</div>
    </div>
  </div>
--}}



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
        
    <div class="col-lg-11">
        <form class="form-horizontal" role="form" method="POST" action="/dashboard/settings" enctype="multipart/form-data">
        	
         	<div class="form-group">
                <div class="">
                    <button type="submit" class="btn btn-primary d-block w-25 mt-5 mb-2 mx-auto"><span class="octicon octicon-sync"></span>更　新</button>
                </div>
            </div>   

            {{ csrf_field() }}
            
            @if(isset($edit))
                <input type="hidden" name="edit_id" value="{{$id}}">
            @endif
		
  			<h4 class="mt-5"><span class="text-info">■</span> メール設定</h4>
     		<hr>              
			<fieldset class="mb-4 form-group{{ $errors->has('admin_name') ? ' has-error' : '' }}">
                <label>管理者名</label>
                <input class="form-control{{ $errors->has('admin_name') ? ' is-invalid' : '' }}" name="admin_name" value="{{ Ctm::isOld() ? old('admin_name') : (isset($setting) ? $setting->admin_name : '') }}">

                @if ($errors->has('admin_name'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('admin_name') }}</span>
                    </div>
                @endif
            </fieldset>
            
            <fieldset class="mb-4 form-group{{ $errors->has('admin_email') ? ' has-error' : '' }}">
                <label>管理者メールアドレス</label>
                <input class="form-control{{ $errors->has('admin_email') ? ' is-invalid' : '' }}" name="admin_email" value="{{ Ctm::isOld() ? old('admin_email') : (isset($setting) ? $setting->admin_email : '') }}">

                @if ($errors->has('admin_email'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('admin_email') }}</span>
                    </div>
                @endif
            </fieldset>
            
            
            
            
            <fieldset class="mb-4 form-group{{ $errors->has('mail_footer') ? ' has-error' : '' }}">
                    <label for="mail_footer" class="control-label">共通メールフッター</label>

                    <textarea id="mail_footer" type="text" class="form-control" name="mail_footer" rows="8">{{ Ctm::isOld() ? old('mail_footer') : (isset($setting) ? $setting->mail_footer : '') }}</textarea>

                    @if ($errors->has('mail_footer'))
                        <span class="help-block">
                            <strong>{{ $errors->first('mail_footer') }}</strong>
                        </span>
                    @endif
            </fieldset>
            
            
            <h4 class="mt-5 pt-4"><span class="text-info">■</span> Shop設定</h4>
            <hr>
            
            <fieldset class="form-group mb-4">
                <div class="checkbox">
                    <label>
                        <?php
                            $checked = '';
                            if(Ctm::isOld()) {
                                if(old('is_product'))
                                    $checked = ' checked';
                            }
                            else {
                                if(isset($setting) && $setting->is_product) {
                                    $checked = ' checked';
                                }
                            }
                        ?>
            
                        <input type="checkbox" name="is_product" value="1"{{ $checked }}> 本番環境（GMO）に接続する
                    </label>
                </div>
            </fieldset>
            
            
            <fieldset class="mb-4 form-group{{ $errors->has('tax_per') ? ' has-error' : '' }}">
                <label>消費税率</label><br>
                <input class="form-control d-inline-block col-md-4{{ $errors->has('tax_per') ? ' is-invalid' : '' }}" name="tax_per" value="{{ Ctm::isOld() ? old('tax_per') : (isset($setting) ? $setting->tax_per : '') }}"> <span>%</span>

                @if ($errors->has('tax_per'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('tax_per') }}</span>
                    </div>
                @endif
            </fieldset>
            
            <fieldset class="form-group mt-5 mb-0">
                <div class="checkbox">
                    <label>
                        <?php
                            $checked = '';
                            if(Ctm::isOld()) {
                                if(old('is_sale'))
                                    $checked = ' checked';
                            }
                            else {
                                if(isset($setting) && $setting->is_sale) {
                                    $checked = ' checked';
                                }
                            }
                        ?>
                        <input type="checkbox" name="is_sale" value="1"{{ $checked }}> セール中にする
                    </label>
                </div>
            </fieldset>
            
            <fieldset class="mb-4 form-group{{ $errors->has('sale_per') ? ' has-error' : '' }}">
                <label>割引率（%）</label>
                <input class="form-control d-inline-block col-md-3{{ $errors->has('sale_per') ? ' is-invalid' : '' }}" name="sale_per" value="{{ Ctm::isOld() ? old('sale_per') : (isset($setting) ? $setting->sale_per : '') }}"> <span>%</span>

                @if ($errors->has('sale_per'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('sale_per') }}</span>
                    </div>
                @endif
            </fieldset>
            
            
            <fieldset class="form-group mt-5 mb-0">
                <div class="checkbox">
                    <label>
                        <?php
                            $checked = '';
                            if(Ctm::isOld()) {
                                if(old('is_point'))
                                    $checked = ' checked';
                            }
                            else {
                                if(isset($setting) && $setting->is_point) {
                                    $checked = ' checked';
                                }
                            }
                        ?>
            
                        <input type="checkbox" name="is_point" value="1"{{ $checked }}> ポイント祭にする
                    </label>
                </div>
            </fieldset>
            
            <fieldset class="mb-4 form-group{{ $errors->has('point_per') ? ' has-error' : '' }}">
                <label>還元率（%）</label>
                <input class="form-control d-inline-block col-md-3{{ $errors->has('point_per') ? ' is-invalid' : '' }}" name="point_per" value="{{ Ctm::isOld() ? old('point_per') : (isset($setting) ? $setting->point_per : '') }}"> <span>%</span>

                @if ($errors->has('point_per'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('point_per') }}</span>
                    </div>
                @endif
            </fieldset>
            
            
            <fieldset class="mt-5 mb-4 form-group{{ $errors->has('kare_ensure') ? ' has-error' : '' }}">
                <label>枯れ保証日数</label><br>
                <input class="form-control d-inline-block col-md-4{{ $errors->has('kare_ensure') ? ' is-invalid' : '' }}" name="kare_ensure" value="{{ Ctm::isOld() ? old('kare_ensure') : (isset($setting) ? $setting->kare_ensure : '') }}"> <span>日</span>

                @if ($errors->has('kare_ensure'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('kare_ensure') }}</span>
                    </div>
                @endif
            </fieldset>
            
            
            <fieldset class="mt-5 mb-4 form-group{{ $errors->has('bank_info') ? ' has-error' : '' }}">
                    <label for="bank_info" class="control-label">銀行振込先</label>

                    <textarea id="bank_info" type="text" class="form-control" name="bank_info" rows="8">{{ Ctm::isOld() ? old('bank_info') : (isset($setting) ? $setting->bank_info : '') }}</textarea>

                    @if ($errors->has('bank_info'))
                        <span class="help-block">
                            <strong>{{ $errors->first('bank_info') }}</strong>
                        </span>
                    @endif
            </fieldset>
            
            
            <h4 class="mt-5 pt-4"><span class="text-info">■</span> 画像設定</h4>
            <hr>
            
            
            @if(Auth::guard('admin')->id() == 2)
                <label>アイコン設定</label><br>
                
                @foreach($icons as $icon)
                    <div class="clearfix spare-img thumb-wrap mb-4">
                        <fieldset class="clearfix col-md-8">

                            <div class="w-50 float-left thumb-prev pr-3">
                                @if(isset($icon) && $icon->img_path)
                                    <img src="{{ Storage::url($icon->img_path) }}" class="img-fluid">
                                @else
                                    <span class="no-img">No Image</span>
                                @endif
                            </div>
                             
                            <div class="w-50 float-left text-left form-group{{ $errors->has($icon->name) ? ' has-error' : '' }}">
                                <label for="model_thumb" class="text-left">{{ $icon->title }} アイコン</label>
                                
                                <div class="w-100">
                                    <input id="{{ $icon->name }}" class="thumb-file" type="file" name="{{ $icon->name }}">
                                    
                                    @if ($errors->has($icon->name))
                                        <span class="help-block">
                                            <strong>{{ $errors->first($icon->name) }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </fieldset>
                    </div>
                @endforeach
            @endif
            
            
 			<fieldset class="pt-4 mb-4 form-group{{ $errors->has('snap_news') ? ' has-error' : '' }}">
                <label>TOPお知らせ用画像の枚数</label><br>
                <input class="form-control d-inline-block col-md-4{{ $errors->has('snap_news') ? ' is-invalid' : '' }}" name="snap_news" value="{{ Ctm::isOld() ? old('snap_news') : (isset($setting) ? $setting->snap_news : '') }}"> <span>枚</span>

                @if ($errors->has('snap_news'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('snap_news') }}</span>
                    </div>
                @endif
            </fieldset>
            
            
            <fieldset class="mb-5 form-group{{ $errors->has('snap_top') ? ' has-error' : '' }}">
                <label>TOPヘッダースライド画像の枚数</label><br>
                <input class="form-control d-inline-block col-md-4{{ $errors->has('snap_top') ? ' is-invalid' : '' }}" name="snap_top" value="{{ Ctm::isOld() ? old('snap_top') : (isset($setting) ? $setting->snap_top : '') }}"> <span>枚</span>

                @if ($errors->has('snap_top'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('snap_top') }}</span>
                    </div>
                @endif
            </fieldset>
            
            <fieldset class="mb-4 form-group{{ $errors->has('snap_primary') ? ' has-error' : '' }}">
                <label>商品サブ画像の枚数</label><br>
                <input class="form-control d-inline-block col-md-4{{ $errors->has('snap_primary') ? ' is-invalid' : '' }}" name="snap_primary" value="{{ Ctm::isOld() ? old('snap_primary') : (isset($setting) ? $setting->snap_primary : '') }}"> <span>枚</span>

                @if ($errors->has('snap_primary'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('snap_primary') }}</span>
                    </div>
                @endif
            </fieldset>
            
            <fieldset class="mb-5 form-group{{ $errors->has('snap_secondary') ? ' has-error' : '' }}">
                <label>商品コンテンツ画像の枚数</label><br>
                <input class="form-control d-inline-block col-md-4{{ $errors->has('snap_secondary') ? ' is-invalid' : '' }}" name="snap_secondary" value="{{ Ctm::isOld() ? old('snap_secondary') : (isset($setting) ? $setting->snap_secondary : '') }}"> <span>枚</span>

                @if ($errors->has('snap_secondary'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('snap_secondary') }}</span>
                    </div>
                @endif
            </fieldset>
            
            
            <fieldset class="mb-4 form-group{{ $errors->has('snap_block_a') ? ' has-error' : '' }}">
                <label>上部コンテンツ（Aブロック）の個数</label><br>
                <input class="form-control d-inline-block col-md-4{{ $errors->has('snap_block_a') ? ' is-invalid' : '' }}" name="snap_block_a" value="{{ Ctm::isOld() ? old('snap_block_a') : (isset($setting) ? $setting->snap_block_a : '') }}"> <span>個</span>

                @if ($errors->has('snap_block_a'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('snap_block_a') }}</span>
                    </div>
                @endif
            </fieldset>
            
            <fieldset class="mb-4 form-group{{ $errors->has('snap_block_b') ? ' has-error' : '' }}">
                <label>上部コンテンツ（Bブロック）の個数</label><br>
                <input class="form-control d-inline-block col-md-4{{ $errors->has('snap_block_b') ? ' is-invalid' : '' }}" name="snap_block_b" value="{{ Ctm::isOld() ? old('snap_block_b') : (isset($setting) ? $setting->snap_block_b : '') }}"> <span>個</span>

                @if ($errors->has('snap_block_b'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('snap_block_b') }}</span>
                    </div>
                @endif
            </fieldset>
            
            <fieldset class="mb-5 form-group{{ $errors->has('snap_block_c') ? ' has-error' : '' }}">
                <label>上部コンテンツ（Cブロック）の個数</label><br>
                <input class="form-control d-inline-block col-md-4{{ $errors->has('snap_block_c') ? ' is-invalid' : '' }}" name="snap_block_c" value="{{ Ctm::isOld() ? old('snap_block_c') : (isset($setting) ? $setting->snap_block_c : '') }}"> <span>個</span>

                @if ($errors->has('snap_block_c'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('snap_block_c') }}</span>
                    </div>
                @endif
            </fieldset>
            
            
            <fieldset class="mb-4 form-group{{ $errors->has('snap_category') ? ' has-error' : '' }}">
                <label>カテゴリー・タグ画像の枚数</label><br>
                <input class="form-control d-inline-block col-md-4{{ $errors->has('snap_category') ? ' is-invalid' : '' }}" name="snap_category" value="{{ Ctm::isOld() ? old('snap_category') : (isset($setting) ? $setting->snap_category : '') }}"> <span>枚</span>

                @if ($errors->has('snap_category'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('snap_category') }}</span>
                    </div>
                @endif
            </fieldset>
            
            <fieldset class="mb-4 form-group{{ $errors->has('snap_fix') ? ' has-error' : '' }}">
                <label>固定ページ画像の枚数</label><br>
                <input class="form-control d-inline-block col-md-4{{ $errors->has('snap_fix') ? ' is-invalid' : '' }}" name="snap_fix" value="{{ Ctm::isOld() ? old('snap_fix') : (isset($setting) ? $setting->snap_fix : '') }}"> <span>枚</span>

                @if ($errors->has('snap_fix'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('snap_fix') }}</span>
                    </div>
                @endif
            </fieldset>
            
            
            
            
            
            <h4 class="mt-5 pt-4"><span class="text-info">■</span> 固定ページID</h4>
            <hr>
            <fieldset class="mb-4 form-group{{ $errors->has('fix_need') ? ' has-error' : '' }}">
                <label>会社関連など必ず必要なページのID（半角数字、カンマで区切り、順番通りに表示されます。）</label><br>
                <input class="form-control d-inline-block col-md-6{{ $errors->has('fix_need') ? ' is-invalid' : '' }}" name="fix_need" value="{{ Ctm::isOld() ? old('fix_need') : (isset($setting) ? $setting->fix_need : '') }}">

                @if ($errors->has('fix_need'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('fix_need') }}</span>
                    </div>
                @endif
            </fieldset>

			<fieldset class="mb-4 form-group{{ $errors->has('fix_other') ? ' has-error' : '' }}">
                <label>その他のページ（半角数字、カンマで区切り、順番通りに表示されます。）</label><br>
                <input class="form-control d-inline-block col-md-6{{ $errors->has('fix_other') ? ' is-invalid' : '' }}" name="fix_other" value="{{ Ctm::isOld() ? old('fix_other') : (isset($setting) ? $setting->fix_other : '') }}">

                @if ($errors->has('fix_other'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('fix_other') }}</span>
                    </div>
                @endif
            </fieldset>
            
            
            <h4 class="mt-5 pt-4"><span class="text-info">■</span> Other</h4>
            <hr>
            <fieldset class="mt-1 mb-4 form-group{{ $errors->has('analytics_code') ? ' has-error' : '' }}">
                <label for="analytics_code" class="control-label">アナリティクスコード</label>

                <textarea id="analytics_code" type="text" class="form-control" name="analytics_code" rows="15">{{ Ctm::isOld() ? old('analytics_code') : (isset($setting) ? $setting->analytics_code : '') }}</textarea>

                @if ($errors->has('analytics_code'))
                    <span class="help-block">
                        <strong>{{ $errors->first('analytics_code') }}</strong>
                    </span>
                @endif
            </fieldset>

            
            <div class="form-group mt-3">
                <button type="submit" class="btn btn-primary d-block w-25 mt-5 mx-auto"><span class="octicon octicon-sync"></span>更　新</button>
            </div>


            

        </form>

    </div>

    

@endsection
