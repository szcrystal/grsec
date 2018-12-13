<?php
$delName = $block .'_del_img';
$imgName = $block .'_img';
$titleName = $block .'_title';
$contName = $block .'_contents';
?>




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
                        if(isset($upperRel[$n]) && $upperRel[$n]->$delName) {
                            $checked = ' checked';
                        }
                    }
                ?>

                <input type="hidden" name="block[{{ $block }}][{{$n}}][del_img]" value="0">
                <input type="checkbox" name="block[{{ $block }}][{{$n}}][del_img]" value="1"{{ $checked }}> この画像を削除
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
            
            @elseif(isset($upperRel[$n]))
            	<img src="{{ Storage::url($upperRel[$n]->img_path) }}" class="img-fluid">
            
            @else
            	<span class="no-img">No Image</span>
            @endif
        </div>
        

        <div class="float-left col-md-8 pl-3 pr-0">
            <fieldset class="form-group{{ $errors->has($imgName) ? ' is-invalid' : '' }}">
                <label>画像</label>
                <input class="form-control-file thumb-file" type="file" name="block[{{ $block }}][{{$n}}][img]">
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
        <input class="form-control col-md-12{{ $errors->has($titleName.$n) ? ' is-invalid' : '' }}" name="block[{{ $block }}][{{$n}}][title]" value="{{ Ctm::isOld() ? old($titleName.$n) : (isset($upperRel[$n]) ? $upperRel[$n]->title : '') }}" placeholder="">

            @if ($errors->has($titleName.$n))
                <div class="text-danger">
                    <span class="fa fa-exclamation form-control-feedback"></span>
                    <span>{{ $errors->first($titleName.$n) }}</span>
                </div>
            @endif
    </fieldset>
        
    
    <fieldset class="my-3 form-group{{ $errors->has($contName.$n) ? ' is-invalid' : '' }}">
        <label class="control-label">詳細</label>
        <textarea class="form-control" name="block[{{ $block }}][{{$n}}][detail]" rows="10">{{ Ctm::isOld() ? old($contName.$n) : (isset($upperRel[$n]) ? $upperRel[$n]->detail : '') }}</textarea>

        @if ($errors->has($contName.$n))
            <span class="help-block">
                <strong>{{ $errors->first($contName.$n) }}</strong>
            </span>
        @endif
    </fieldset>
</div>

{{--
{{ $upperRel[$n]->id }}
--}}

<?php
	$relId = isset($upperRel[$n]) ? $upperRel[$n]->id : 0;
?>
<input type="hidden" name="block[{{ $block }}][{{$n}}][rel_id]" value="{{ $relId }}">

<input type="hidden" name="block[{{ $block }}][{{$n}}][count]" value="{{ $n }}">






