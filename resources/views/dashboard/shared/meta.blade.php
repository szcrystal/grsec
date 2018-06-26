<fieldset class="form-group{{ $errors->has('meta_title') ? ' has-error' : '' }}">
        <label for="meta_title" class="control-label">Meta Title</label>

            <input id="meta_title" type="text" class="form-control col-md-12" name="meta_title" value="{{ Ctm::isOld() ? old('meta_title') : (isset($obj) ? $obj->meta_title : '') }}">

        @if ($errors->has('meta_title'))
            <div class="text-danger">
                <span class="fa fa-exclamation form-control-feedback"></span>
                <span>{{ $errors->first('meta_title') }}</span>
            </div>
        @endif
    </fieldset>
    
    <fieldset class="form-group{{ $errors->has('meta_description') ? ' has-error' : '' }}">
        <label for="slug" class="control-label">Meta Description</label>

            <textarea id="meta_description" type="text" class="form-control col-md-12" name="meta_description" rows="6">{{ Ctm::isOld() ? old('meta_description') : (isset($obj) ? $obj->meta_description : '') }}</textarea>

        @if ($errors->has('meta_description'))
            <div class="text-danger">
                <span class="fa fa-exclamation form-control-feedback"></span>
                <span>{{ $errors->first('meta_description') }}</span>
            </div>
        @endif
    </fieldset>
    
    <fieldset class="form-group{{ $errors->has('meta_keyword') ? ' has-error' : '' }}">
        <label for="slug" class="control-label">Meta KeyWord（,カンマで区切って下さい）</label>

            <input id="meta_keyword" type="text" class="form-control col-md-12" name="meta_keyword" value="{{ Ctm::isOld() ? old('meta_keyword') : (isset($obj) ? $obj->meta_keyword : '') }}">

        @if ($errors->has('meta_keyword'))
            <div class="text-danger">
                <span class="fa fa-exclamation form-control-feedback"></span>
                <span>{{ $errors->first('meta_keyword') }}</span>
            </div>
        @endif
    </fieldset>
            
