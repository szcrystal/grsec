<?php
$delName = $block .'_del_img';
$imgName = $block .'_img';
$titleName = $block .'_title';
$contName = $block .'_contents';
?>


{{--
<div class="clearfix spare-img thumb-wrap">  
            <fieldset class="w-25 float-right">
                <div class="checkbox text-right pr-1">
                    <label>
                        <?php
                            $checked = '';
                            if(Ctm::isOld()) {
                                if(old('del_news.'.$n))
                                    $checked = ' checked';
                            }
                            else {
                                if(isset($obj) && $obj->del_news) {
                                    $checked = ' checked';
                                }
                            }
                        ?>

                        <input type="hidden" name="del_news[{{$n}}]" value="0">
                        <input type="checkbox" name="del_news[{{$n}}]" value="1"{{ $checked }}> この画像を削除
                    </label>
                </div>
            </fieldset>
        
            <fieldset class="float-left clearfix w-75">

                <div class="w-25 float-left thumb-prev pr-3">
                    @if(count(old()) > 0)
                        @if(old('news_thumb.'.$n) != '' && old('news_thumb.'.$n))
                            <img src="{{ Storage::url(old('news_thumb.'.$n)) }}" class="img-fluid">
                        @elseif(isset($newsSnaps[$n]) && $newsSnaps[$n]->snap_path)
                            <img src="{{ Storage::url($newsSnaps[$n]->snap_path) }}" class="img-fluid">
                        @else
                            <span class="no-img">No Image</span>
                        @endif
                    @elseif(isset($newsSnaps[$n]) && $newsSnaps[$n]->img_path)
                        <img src="{{ Storage::url($newsSnaps[$n]->img_path) }}" class="img-fluid">
                    @else
                        <span class="no-img">No Image</span>
                    @endif
                </div>
                 
                <div class="w-75 float-left text-left form-group{{ $errors->has('snap_thumb.'.$n) ? ' has-error' : '' }}">
                    <label for="model_thumb" class="text-left">
                        お知らせ用画像&nbsp;<span class="text-secondary">{{ $n+1 }}</span>
                    </label>
                    
                    <div class="w-100">
                        <input class="thumb-file" type="file" name="news_thumb[]">
                        
                        @if(isset($newsSnaps[$n]) && $newsSnaps[$n]->img_path)
                            <p class="mt-4 mb-0 text-info">src="{{ Storage::url($newsSnaps[$n]->img_path) }}"</p>
                        @endif                  
                        
                        @if ($errors->has('news_thumb.'.$n))
                            <span class="help-block">
                                <strong>{{ $errors->first('news_thumb.'.$n) }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </fieldset>
        </div>
--}}




<h5 style="border-bottom: 1px solid #ccc; text-transform:uppercase;" class="mb-3">{{ $block }}ブロック-{{ $n+1 }} </h5>
<div class="form-group clearfix mb-4 thumb-wrap">
    <fieldset class="w-25 float-right">
        <div class="col-md-12 checkbox text-right px-0">
            <label>
                <?php
                    $checked = '';
                    if(Ctm::isOld($delName.$n)) {
                        if(old($delName.$n))
                            $checked = ' checked';
                    }
                    else {
                        if(isset($item) && $item->$delName) {
                            $checked = ' checked';
                        }
                    }
                ?>

                <input type="hidden" name="{{ $delName }}[{{ $n }}]" value="0">
                <input type="checkbox" name="{{ $delName }}[{{ $n }}]" value="1"{{ $checked }}> この画像を削除
            </label>
        </div>
    </fieldset>
    
    <fieldset>
        <div class="float-left col-md-4 px-0 thumb-prev">
            @if(count(old()) > 0)
                @if(old($imgName.$n) != '' && old($imgName.$n))
                	<img src="{{ Storage::url(old($imgName.$n)) }}" class="img-fluid">
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
            <fieldset class="form-group{{ $errors->has($imgName) ? ' is-invalid' : '' }}">
                <label>画像</label>
                <input class="form-control-file thumb-file" type="file" name="{{ $imgName }}[]">
            </fieldset>
        
            @if ($errors->has($imgName.$n))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first($imgName.$n) }}</strong>
                </span>
            @endif
            
            {{-- <span class="text-small text-secondary">＊メイン画像は原則必要なものとなります。<br>削除後の未入力など注意して下さい。</span> --}}
        
        </div>
    </fieldset>
    
    <fieldset class="my-2 form-group{{ $errors->has($titleName.$n) ? ' is-invalid' : '' }}">
        <label>タイトル</label>
        <input class="form-control col-md-12{{ $errors->has($titleName.$n) ? ' is-invalid' : '' }}" name="{{ $titleName }}[]" value="{{ Ctm::isOld() ? old($titleName.$n) : (isset($item) ? $item->$titleName : '') }}" placeholder="">

            @if ($errors->has($titleName.$n))
                <div class="text-danger">
                    <span class="fa fa-exclamation form-control-feedback"></span>
                    <span>{{ $errors->first($titleName.$n) }}</span>
                </div>
            @endif
    </fieldset>
        
    
    <fieldset class="my-3 form-group{{ $errors->has($contName.$n) ? ' is-invalid' : '' }}">
        <label class="control-label">詳細</label>
        <textarea class="form-control" name="{{ $contName }}[]" rows="10">{{ Ctm::isOld() ? old($contName.$n) : (isset($item) ? $item->$contName : '') }}</textarea>

        @if ($errors->has($contName.$n))
            <span class="help-block">
                <strong>{{ $errors->first($contName.$n) }}</strong>
            </span>
        @endif
    </fieldset>
</div>






