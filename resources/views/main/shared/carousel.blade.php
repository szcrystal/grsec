<?php
//use App\User;
?>

<div id="carouselIndicators" class="carousel slide" data-ride="carousel" data-interval="10000">
  
  <div class="carousel-inner" role="listbox">

    <?php $n = 0; ?>

	@if(isset($caros))
    	@foreach($caros as $caro)

            @if($n > 0)
                <div class="carousel-item">
            @else
                <div class="carousel-item active">
            @endif
            	
              	<img class="d-block img-fluid w-100" src="{{ Storage::url($caro->img_path) }}" alt="slide">
              	<div class="carousel-caption d-none d-md-block">
                	<h3></h3>
                </div>
            </div>
            
            <?php $n++; ?>

        @endforeach

	@else
        @foreach($newAtcl as $obj)

            @if($n > 0)
                <div class="carousel-item">
            @else
                <div class="carousel-item active">
            @endif
            	<a href="{{ url(Ctm::getAtclUrl($obj->id)) }}">
                    <img class="d-block img-fluid" src="{{ Storage::url($obj->thumb_path) }}" alt="slide">
                    <div class="carousel-caption d-none d-md-block">
                        <h3>{{ $obj->title}}</h3>
                        <p>{{ User::find($obj->model_id)->name}}
                        @if($obj->model_id > 2)
                            ＠{{ User::find($obj->model_id)->school }}
                        @endif
                        </p>
                    </div>
				</a>
            	</div>
            
            <?php $n++; ?>

        @endforeach
    @endif

    </div>
    
    <ol class="carousel-indicators">
  	<?php
    	$i = 0; 
    ?>
  	@foreach($caros as $caro)
    	@if($i)
        	<?php $active = ''; ?>
        @else
        	<?php $active = ' class="active"'; ?>
        @endif
        
        <li data-target="#carouselIndicators" data-slide-to="{{ $i }}"{!! $active !!}>
            <img class="img-fluid" src="{{ Storage::url($caro->img_path) }}" alt="indicator">
        </li>
        	
        
        <?php $i++; ?>
    @endforeach
  </ol>



<!--
  <a class="carousel-control-prev" href="#carouselIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
  -->

</div>
