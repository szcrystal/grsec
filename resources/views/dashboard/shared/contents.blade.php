
    <fieldset class="mb-4 form-group{{ $errors->has('contents') ? ' is-invalid' : '' }}">
        <label for="contents" class="control-label">
            @if(isset($type) && $type == 'top')
            TOPお知らせ枠(HTML)
            @else
            コンテンツ
            @endif
        </label>

        <?php
            $rows = (isset($type) && $type == 'top') ? 20 : 35;
        ?>
        
        <textarea class="form-control" name="contents" rows="{{ $rows }}">{{ Ctm::isOld() ? old('contents') : (isset($obj) ? $obj->contents : '') }}</textarea>

        @if ($errors->has('contents'))
            <span class="help-block">
                <strong>{{ $errors->first('contents') }}</strong>
            </span>
        @endif
    </fieldset>
    
    @if(isset($type) && $type == 'top')
    	<?php
            $n=0;
        ?>
        
        @while($n < $newsCount)
        
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
        <hr>
        
        <input type="hidden" name="news_count[]" value="{{ $n }}">

        <?php $n++; ?>
        @endwhile
        
        <div class="form-group mt-3 clearfix">
            <button type="submit" class="btn btn-primary d-block w-25 mt-5 float-right"><span class="octicon octicon-sync"></span>更　新</button>
        </div>
    
    @endif
    
    
    
    <hr class="mt-5 mb-3 border-0">
    
    @if(isset($type) && $type == 'top')
    	<h5>TOPヘッダースライド画像</h5>
        <label class="mt-3 mb-4"><span class="text-small p-0 m-0">*（縦横サイズは任意、全ての画像を同じサイズで揃えて下さい。）</span></label> 
    @else
    	<h5>コンテンツ画像</h5>
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
            
            @if(isset($type) && $type == 'top')
                <div class="clearfix">
                    <fieldset class="mt-2 mb-4 form-group{{ $errors->has('link.'.$n) ? ' is-invalid' : '' }}">
                        <label>リンク先</label><br>
                        <input class="form-control col-md-12" name="link[]" value="{{ Ctm::isOld() ? old('link.'.$n) : (isset($snaps[$n]) ? $snaps[$n]->link : '') }}">
                    </fieldset>
                </div>
            @endif
                       
        <hr>

        <input type="hidden" name="snap_count[]" value="{{ $n }}">

        <?php $n++; ?>
        @endwhile
    </div>
            
