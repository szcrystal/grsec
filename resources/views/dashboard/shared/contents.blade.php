
    <fieldset class="mb-4 form-group{{ $errors->has('contents') ? ' is-invalid' : '' }}">
            <label for="contents" class="control-label">
            	@if(isset($type) && $type == 'top')
                TOPお知らせ枠(HTML)
            	@else
                コンテンツ
                @endif
            </label>

            <textarea class="form-control" name="contents" rows="22">{{ Ctm::isOld() ? old('contents') : (isset($obj) ? $obj->contents : '') }}</textarea>

            @if ($errors->has('contents'))
                <span class="help-block">
                    <strong>{{ $errors->first('contents') }}</strong>
                </span>
            @endif
    </fieldset>
    
    <hr class="mt-0 mb-2 py-0">
    
    @if(isset($type) && $type == 'top')
        <label class="mt-3 mb-4">TOPヘッダー画像&nbsp;&nbsp;<span class="text-small p-0 m-0">*（縦横サイズは任意、全ての画像を同じサイズで揃えて下さい。）</span></label>   
    @endif
    
    <div class="clearfix mb-3">
    	<span class="text-small text-secondary d-block mb-3">＊UPする画像のファイル名は全て半角英数字とハイフンのみで構成して下さい。(abc-123.jpg など)</span>

        <?php
            $n=0;
            //use App\Setting;
            //$setCount = 5;
            //$setCount = Setting::get()->first()->snap_count;
        ?>
        
        @while($n < $imgCount)

            <div class="clearfix spare-img thumb-wrap">  
                <fieldset class="w-25 float-right">
                    <div class="checkbox text-right pr-1">
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
            
                <fieldset class="float-left clearfix w-75">

                    <div class="w-25 float-left thumb-prev pr-3">
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
                     
                    <div class="w-75 float-left text-left form-group{{ $errors->has('snap_thumb.'.$n) ? ' has-error' : '' }}">
                        <label for="model_thumb" class="text-left">
                            @if(isset($type) && $type == 'top')
                                ヘッダー画像
                            @else
                                コンテンツ画像
                            @endif
                            &nbsp;<span class="text-secondary">{{ $n+1 }}</span>
                        </label>
                        
                        <div class="w-100">
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
            
