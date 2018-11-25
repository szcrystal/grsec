<?php
use App\TopSetting;
?>

<div class="tophead-wrap">
    <div class="clearfix">
        {!! TopSetting::get()->first()->contents !!}
    </div>
    
    @if(isset($isTop) && $isTop)
        @include('main.shared.carousel')
    @endif
</div>
