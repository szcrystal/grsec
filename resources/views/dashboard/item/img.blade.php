<?php
$spare_img = "spare_img_$i";
//echo $item->$spare_img;
?>
	
<div class="mb-1 thumb-wrap spare-img col-md-6 float-left">
    
    <div class="clearfix">
    <div class="float-left w-25 thumb-prev">
        @if(count(old()) > 0)
            @if(old($spare_img) != '' && old($spare_img))
            	<img src="{{ Storage::url(old($spare_img)) }}" class="img-fluid">
            @elseif(isset($item) && $item[$spare_img])
            	<img src="{{ Storage::url($item[$spare_img]) }}" class="img-fluid">
            @else
            	<span class="no-img">No Image</span>
            @endif
        @elseif(isset($item) && $item[$spare_img])
        	<img src="{{ Storage::url($item[$spare_img]) }}" class="img-fluid">
        @else
        	<span class="no-img">No Image</span>
        @endif
    </div>

    <div class="float-left col-md-8">
        <fieldset class="form-group{{ $errors->has('spare_img') ? ' is-invalid' : '' }}">
            <label for="spare_img">{{ $i+1 }}</label>
            <input class="form-control-file thumb-file" id="spare_img" type="file" name="spare_img[]">
            <input type="hidden" name="del_spareimg[]" val="0">
        
            <div class="text-info mt-1 del-spareimg{{ isset($item) && $item[$spare_img] ? '' : ' hide' }}">
            	<i class="fa fa-times-circle"></i> 削除する
            </div>
           
            
            
        </fieldset>
    </div>
    
    @if ($errors->has('spare_img'))
        <span class="help-block text-danger">
            <strong>{{ $errors->first('spare_img') }}</strong>
        </span>
    @endif
    
    
    
    
    </div>
    <hr>
</div>




