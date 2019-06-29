<?php
use App\Icon;
?>


<?php $icons = explode(',', $obj->icon_id); ?>

@foreach($icons as $iconId)
    <?php $iconObj = Icon::find($iconId); ?>
    
    <span class="{{ $iconObj->name }}">{{ $iconObj->title }}</span>

@endforeach
            
<span class="creca">クレカOK</span>       


