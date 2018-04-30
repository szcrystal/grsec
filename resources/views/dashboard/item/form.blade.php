@extends('layouts.appDashBoard')

@section('content')
	
	<div class="text-left">
        <h1 class="Title">
        @if(isset($edit))
        商品編集
        @else
        商品新規追加
        @endif
        </h1>
        <p class="Description"></p>
    </div>

    <div class="row">
      <div class="col-sm-12 col-md-6 col-lg-6 col-xl-5 mb-5">
        <div class="bs-component clearfix">
        <div class="pull-left">
            <a href="{{ url('/dashboard/items') }}" class="btn bg-white border border-1 border-round border-secondary text-primary"><i class="fa fa-angle-double-left" aria-hidden="true"></i>一覧へ戻る</a>
        </div>
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
        
    <div class="col-lg-10">
        <form class="form-horizontal" role="form" method="POST" action="/dashboard/items" enctype="multipart/form-data">
			@if(isset($edit))
                <input type="hidden" name="edit_id" value="{{$id}}">
            @endif

            {{ csrf_field() }}
            
            @if(isset($edit))
                <input type="hidden" name="edit_id" value="{{$id}}">
            @endif

		<div class="form-group">
                <div class="col-md-12 text-right">
                    <div class="checkbox">
                        <label>
                            <?php
                                $checked = '';
                                if(Ctm::isOld()) {
                                    if(old('open_status'))
                                        $checked = ' checked';
                                }
                                else {
                                    if(isset($atcl) && ! $atcl->open_status) {
                                        $checked = ' checked';
                                    }
                                }
                            ?>
                            <input type="checkbox" name="open_status" value="1"{{ $checked }}> この記事を非公開にする
                        </label>
                    </div>
                </div>
            </div>
	
		<div class="row clearfix mb-4 thumb-wrap">
            <div class="float-left col-md-5 thumb-prev">
                @if(count(old()) > 0)
                    @if(old('main_img') != '' && old('main_img'))
                    <img src="{{ Storage::url(old('main_img')) }}" class="img-fluid">
                    @elseif(isset($item) && $item->thumbnail)
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

            <div class="float-left col-md-7">
                <fieldset class="form-group{{ $errors->has('main_img') ? ' is-invalid' : '' }}">
                    <label for="main_img">商品画像</label>
                    <input class="form-control-file thumb-file" id="main_img" type="file" name="main_img">
                </fieldset>
            </div>
            
            @if ($errors->has('main_img'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first('main_img') }}</strong>
                </span>
            @endif
        </div>

			<fieldset class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                <label>商品名</label>
                <input class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ Ctm::isOld() ? old('title') : (isset($item) ? $item->title : '') }}">

                @if ($errors->has('title'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('title') }}</span>
                    </div>
                @endif
            </fieldset>
            
            <div class="form-group{{ $errors->has('cate_id') ? ' has-error' : '' }}">
                <label>カテゴリー</label>
                <select class="form-control select-first" name="cate_id">
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
                
                @if ($errors->has('cate_id'))
                    <span class="help-block text-warning">
                        <strong>{{ $errors->first('cate_id') }}</strong>
                    </span>
                @endif
                
            </div>
            
            
            <fieldset class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                <label for="delivery_fee" class="control-label">値段</label>
                <input class="form-control" name="price" value="{{ Ctm::isOld() ? old('price') : (isset($item) ? $item->price : '') }}">
                <span>円</span>

                @if ($errors->has('price'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('price') }}</span>
                    </div>
                @endif
            </fieldset>
            

            <fieldset class="form-group{{ $errors->has('delivery_fee') ? ' has-error' : '' }}">
                <label for="delivery_fee" class="control-label">送料</label>
                <input class="form-control" name="delivery_fee" value="{{ Ctm::isOld() ? old('delivery_fee') : (isset($item) ? $item->delivery_fee : '') }}">
                <span>円</span>

                @if ($errors->has('delivery_fee'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('delivery_fee') }}</span>
                    </div>
                @endif
            </fieldset>


			<fieldset class="form-group{{ $errors->has('what_is') ? ' has-error' : '' }}">
                    <label for="story_text" class="control-label">What is</label>

                        <textarea id="what_is" type="text" class="form-control" name="what_is" rows="10">{{ Ctm::isOld() ? old('what_is') : (isset($item) ? $item->what_is : '') }}
                        </textarea>

                        @if ($errors->has('what_is'))
                            <span class="help-block">
                                <strong>{{ $errors->first('what_is') }}</strong>
                            </span>
                        @endif
            </fieldset>
            
            <fieldset class="form-group{{ $errors->has('detail') ? ' has-error' : '' }}">
                    <label for="detail" class="control-label">詳細</label>

                        <textarea id="detail" type="text" class="form-control" name="detail" rows="10">{{ Ctm::isOld() ? old('detail') : (isset($item) ? $item->detail : '') }}
                        </textarea>

                        @if ($errors->has('detail'))
                            <span class="help-block">
                                <strong>{{ $errors->first('detail') }}</strong>
                            </span>
                        @endif
            </fieldset>
            
            <fieldset class="form-group{{ $errors->has('warning') ? ' has-error' : '' }}">
                    <label for="warning" class="control-label">ご注意</label>

                    <textarea id="warning" type="text" class="form-control" name="warning" rows="10">{{ Ctm::isOld() ? old('warning') : (isset($item) ? $item->warning : '') }}
                    </textarea>

                    @if ($errors->has('warning'))
                        <span class="help-block">
                            <strong>{{ $errors->first('warning') }}</strong>
                        </span>
                    @endif
            </fieldset>
            
            
            <div class="clearfix tag-wrap">

                <div class="tag-group form-group{{ $errors->has('tag-group') ? ' has-error' : '' }}">
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
            
            
            <div class="form-group">
                <div class="col-md-4 col-md-offset-3">
                    <button type="submit" class="btn btn-primary center-block w-btn"><span class="octicon octicon-sync"></span>更　新</button>
                </div>
            </div>


            

        </form>

    </div>

    

@endsection
