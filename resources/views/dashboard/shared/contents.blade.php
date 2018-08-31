
    <fieldset class="mb-4 form-group{{ $errors->has('detail') ? ' is-invalid' : '' }}">
            <label for="detail" class="control-label">
            	@if(isset($type) && $type == 'top')
                お知らせ枠(HTML)
            	@else
                コンテンツ
                @endif
            </label>

            <textarea id="contents" type="text" class="form-control" name="contents" rows="22">{{ Ctm::isOld() ? old('contents') : (isset($obj) ? $obj->contents : '') }}</textarea>

            @if ($errors->has('contents'))
                <span class="help-block">
                    <strong>{{ $errors->first('contents') }}</strong>
                </span>
            @endif
    </fieldset>
    
    
    @if(isset($type) && $type == 'top')
        <label class="mt-3">TOPヘッダー画像</label>
        <hr class="mt-0 mb-2 py-0">
    @endif
    
    <div class="clearfix mb-3">

        <?php
            $n=0;
            //use App\Setting;
            //$setCount = 5;
            //$setCount = Setting::get()->first()->snap_count;
        ?>
        
        @while($n < $imgCount)

        <div class="clearfix spare-img thumb-wrap">
            
        <fieldset class="col-md-4 float-right">
            <div class="checkbox text-right px-5">
                <label>
                    <?php
                        $checked = '';
                        if(Ctm::isOld()) {
                            if(old('del_snap.'.$n))
                                $checked = ' checked';
                        }
                        else {
                            if(isset($obj) && $obj->del_snap) {
                                $checked = ' checked';
                            }
                        }
                    ?>

                    <input type="hidden" name="del_snap[{{$n}}]" value="0">
                    <input type="checkbox" name="del_snap[{{$n}}]" value="1"{{ $checked }}> この画像を削除
                </label>
            </div>
        </fieldset>
        
        
        
        <fieldset class="float-left clearfix">

            <div class="w-25 float-left thumb-prev">
                @if(count(old()) > 0)
                    @if(old('snap_thumb.'.$n) != '' && old('snap_thumb.'.$n))
                    <img src="{{ Storage::url(old('snap_thumb.'.$n)) }}" class="img-fluid">
                    @elseif(isset($snaps[$n]) && $snaps[$n]->snap_path)
                    <img src="{{ Storage::url($snaps[$n]->snap_path) }}" class="img-fluid">
                    @else
                    <span class="no-img">No Image</span>
                    @endif
                @elseif(isset($snaps[$n]) && $snaps[$n]->img_path)
                    <img src="{{ Storage::url($snaps[$n]->img_path) }}" class="img-fluid">
                @else
                    <span class="no-img">No Image</span>
                @endif
            </div>
			 
            <div class="w-50 float-left text-left form-group{{ $errors->has('snap_thumb.'.$n) ? ' has-error' : '' }}">
                <label for="model_thumb" class="col-md-12 text-left">
                	@if(isset($type) && $type == 'top')
                    	ヘッダー画像
                    @else
                    	コンテンツ画像
                    @endif
                    &nbsp;<span class="text-primary">{{ $n+1 }}</span>
                </label>
                <div class="col-md-12">
                    <input id="model_thumb" class="thumb-file" type="file" name="snap_thumb[]">
                    
                    @if(isset($snaps[$n]) && $snaps[$n]->img_path)
                        <p class="mt-4 mb-0 text-info">src="{{ Storage::url($snaps[$n]->img_path) }}"</p>
                    @endif                  
                    
                    @if ($errors->has('snap_thumb.'.$n))
                        <span class="help-block">
                            <strong>{{ $errors->first('snap_thumb.'.$n) }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </fieldset>
        
        </div>            
        <hr>

        <input type="hidden" name="snap_count[]" value="{{ $n }}">

        <?php $n++; ?>
        @endwhile
    </div>
            
