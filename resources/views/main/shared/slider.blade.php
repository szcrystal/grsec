<?php
//use App\User;
?>

<div class="slider-wrap">

@if(isset($caros))

<div class="slider slider-top">
	 <?php $n = 0; ?>

	
    	@foreach($caros as $caro)
    		<div>
            
        		@if(isset($caro->link) && $caro->link != '')
                	<a href="{{ $caro->link }}">
                @endif
              	
                	<img class="w-100" src="{{ Storage::url($caro->img_path) }}" alt="">
                
                @if(isset($caro->link) && $caro->link != '')
                	</a>
                @endif
    		</div>
            
        <?php $n++; ?>

        @endforeach
</div>

<div class="slider slider-nav">
    
    	@foreach($caros as $caro)
    		<div class="slider-item">
                <img class="w-100" src="{{ Storage::url($caro->img_path) }}" alt="">
    		</div>
        @endforeach
</div>

@endif

<span class="this-item"></span>

</div>
