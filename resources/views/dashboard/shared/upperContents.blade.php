<?php

 //inputのname名：block[a][0][title] など block[{{ $blockKey }}][{{$n}}][title]
$nameFormat = 'block[' . $blockKey . '][' . $n .'][%s]';

//oldやerrorsなどで取得する名前
$oldName = 'block.' .$blockKey . '.' . $n . '.';

?>



<div style="border-bottom: 1px solid #ccc;" class="clearfix mb-4 text-uppercase">

<h5 class="mb-3 float-left d-inline-block">{{ $blockKey }}ブロック-{{ $n+1 }}</h5>

<fieldset class="w-25 form-group float-left mb-0 pb-0 ml-3">
    <div class="col-md-12 checkbox px-0">
        <label>
            <?php
                $checked = '';
                if(Ctm::isOld()) {
                    if(old($oldName . 'del_block'))
                        $checked = ' checked';
                }
                else {
                    if(isset($upperRel[$n]) && $upperRel[$n]->del_block) {
                        $checked = ' checked';
                    }
                }
            ?>

            <input type="hidden" name="{{ sprintf($nameFormat, 'del_block') }}" value="0">
            <input type="checkbox" name="{{ sprintf($nameFormat, 'del_block') }}" value="1"{{ $checked }}> {{ $blockKey }}ブロック-{{ $n+1 }}を削除
        </label>
    </div>
</fieldset>

</div>

<div class="form-group clearfix mb-4 thumb-wrap">
    <fieldset class="w-25 float-right">
        <div class="col-md-12 checkbox text-right px-3">
            <label>
                <?php
                    $checked = '';
                    if(Ctm::isOld()) {
                        if(old($oldName . 'del_img'))
                            $checked = ' checked';
                    }
                    else {
                        if(isset($upperRel[$n]) && $upperRel[$n]->del_img) {
                            $checked = ' checked';
                        }
                    }
                ?>

                <input type="hidden" name="{{ sprintf($nameFormat, 'del_img') }}" value="0">
                <input type="checkbox" name="{{ sprintf($nameFormat, 'del_img') }}" value="1"{{ $checked }}> この画像を削除
            </label>
        </div>
    </fieldset>
    
    <fieldset>
        <div class="float-left col-md-4 px-0 thumb-prev">
            @if(count(old()) > 0)
                @if(old($oldName . '.img') != '' && old($oldName . '.img'))
                	<img src="{{ Storage::url(old($oldName . '.img')) }}" class="img-fluid">
                @elseif(isset($upperRel[$n]) && $upperRel[$n]->img_path)
                	<img src="{{ Storage::url($upperRel[$n]->main_img) }}" class="img-fluid">
                @else
                	<span class="no-img">No Image</span>
                @endif
            
            @elseif(isset($upperRel[$n]) && $upperRel[$n]->img_path)
            	<img src="{{ Storage::url($upperRel[$n]->img_path) }}" class="img-fluid">
            
            @else
            	<span class="no-img">No Image</span>
            @endif
        </div>
        

        <div class="float-left col-md-8 pl-3 pr-0">
            <fieldset class="form-group{{ $errors->has($oldName .'.img') ? ' is-invalid' : '' }}">
                <label>画像</label>
                <input class="form-control-file thumb-file" type="file" name="{{ sprintf($nameFormat, 'img') }}">
            </fieldset>
        
            @if ($errors->has($oldName.'img'))
                <span class="help-block text-danger">
                    <strong>{{ $errors->first($oldName.'img') }}</strong>
                </span>
            @endif
            
        
        </div>
    </fieldset>
    
    <fieldset class="mt-3 my-2 form-group">
        <label>URL</label>
        <input class="form-control col-md-12{{ $errors->has($oldName.'url') ? ' is-invalid' : '' }}" name="{{ sprintf($nameFormat, 'url') }}" value="{{ Ctm::isOld() ? old($oldName.'url') : (isset($upperRel[$n]) ? $upperRel[$n]->url : '') }}" placeholder="">

            @if ($errors->has($oldName.'url'))
                <div class="text-danger">
                    <span class="fa fa-exclamation form-control-feedback"></span>
                    <span>{{ $errors->first($oldName.'url') }}</span>
                </div>
            @endif
    </fieldset>
</div>    



<fieldset class="my-2 form-group">
    <label>タイトル</label>
    <input class="form-control col-md-12{{ $errors->has($oldName.'title') ? ' is-invalid' : '' }}" name="{{ sprintf($nameFormat, 'title') }}" value="{{ Ctm::isOld() ? old($oldName.'title') : (isset($upperRel[$n]) ? $upperRel[$n]->title : '') }}" placeholder="">

        @if ($errors->has($oldName.'title'))
            <div class="text-danger">
                <span class="fa fa-exclamation form-control-feedback"></span>
                <span>{{ $errors->first($oldName.'title') }}</span>
            </div>
        @endif
</fieldset>
    


<fieldset class="my-3 form-group">
    <label class="control-label">詳細（空白枠にする場合は &nbsp; を入力）</label>
    <textarea class="form-control{{ $errors->has($oldName.'detail') ? ' is-invalid' : '' }}" name="{{ sprintf($nameFormat, 'detail') }}" rows="10">{{ Ctm::isOld() ? old($oldName.'detail') : (isset($upperRel[$n]) ? $upperRel[$n]->detail : '') }}</textarea>

    @if ($errors->has($oldName.'detail'))
        <span class="help-block">
            <strong>{{ $errors->first($oldName.'detail') }}</strong>
        </span>
    @endif
</fieldset>





<?php
	$relId = isset($upperRel[$n]) ? $upperRel[$n]->id : 0;
?>

@if(Ctm::isEnv('local'))
<br>
{{ $relId }}
@endif

<input type="hidden" name="{{ sprintf($nameFormat, 'rel_id') }}" value="{{ $relId }}">

<input type="hidden" name="{{ sprintf($nameFormat, 'count') }}" value="{{ $n }}">






