<fieldset class="form-group mb-2 mt-5">
        <div class="checkbox">
            <label>
                <?php
                    $checked = '';
                    if(Ctm::isOld()) {
                        if(old('is_top'))
                            $checked = ' checked';
                    }
                    else {
                        if(isset($obj) && $obj->is_top) {
                            $checked = ' checked';
                        }
                    }
                ?>
                <input type="checkbox" name="is_top" value="1"{{ $checked }}> 「おすすめ」にする
            </label>
        </div>
        
        @if ($errors->has('is_top'))
            <div class="text-danger">
                <span class="fa fa-exclamation form-control-feedback"></span>
                <span>{{ $errors->first('is_top') }}</span>
            </div>
        @endif
</fieldset>

<div class="form-group clearfix mb-4 thumb-wrap">
    <div class="float-left col-md-5 thumb-prev">
        @if(count(old()) > 0)
            @if(old('top_img_path') != '' && old('top_img_path'))
            <img src="{{ Storage::url(old('main_img')) }}" class="img-fluid">
            @elseif(isset($obj) && $obj->top_img_path)
            <img src="{{ Storage::url($obj->top_img_path) }}" class="img-fluid">
            @else
            <span class="no-img">No Image</span>
            @endif
        @elseif(isset($obj) && $obj->top_img_path)
        <img src="{{ Storage::url($obj->top_img_path) }}" class="img-fluid">
        @else
        <span class="no-img">No Image</span>
        @endif
    </div>

    <div class="float-left col-md-7">
        <fieldset class="form-group{{ $errors->has('top_img_path') ? ' is-invalid' : '' }}">
            <label for="main_img">おすすめ画像</label>
            <input class="form-control-file thumb-file" id="top_img_path" type="file" name="top_img_path">
        </fieldset>
    </div>
    
    @if ($errors->has('top_img_path'))
        <span class="help-block text-danger">
            <strong>{{ $errors->first('top_img_path') }}</strong>
        </span>
    @endif
</div>


<fieldset class="form-group mb-4">
    <label for="top_title" class="control-label">おすすめタイトル</label>

    <div class="">
        <input id="top_title" type="text" class="form-control col-md-12{{ $errors->has('top_title') ? ' is-invalid' : '' }}" name="top_title" value="{{ Ctm::isOld() ? old('top_title') : (isset($obj) ? $obj->top_title : '') }}">

        @if ($errors->has('top_title'))
            <div class="text-danger">
                <span class="fa fa-exclamation form-control-feedback"></span>
                <span>{{ $errors->first('top_title') }}</span>
            </div>
        @endif
    </div>
</fieldset>

<fieldset class="mb-5 form-group{{ $errors->has('top_text') ? ' is-invalid' : '' }}">
        <label for="top_text" class="control-label">おすすめ本文</label>

        <textarea id="top_text" type="text" class="form-control" name="top_text" rows="15">{{ Ctm::isOld() ? old('top_text') : (isset($obj) ? $obj->top_text : '') }}</textarea>

        @if ($errors->has('top_text'))
            <span class="help-block text-danger">
                <strong>{{ $errors->first('top_text') }}</strong>
            </span>
        @endif
</fieldset>