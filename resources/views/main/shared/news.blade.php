<?php
use App\TopSetting;
?>

<div class="tophead-wrap">
    <div class="clearfix">
        {!! TopSetting::get()->first()->contents !!}
    </div>
    
    @if(isset($isTop) && $isTop)
        @if(Ctm::isEnv('local'))
        	@include('main.shared.slider')
		@else
        	@include('main.shared.carousel')
        @endif
    @endif
</div>
