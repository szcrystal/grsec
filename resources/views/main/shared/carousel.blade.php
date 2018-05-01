<?php
use App\User;
?>

<div id="carouselIndicators" class="carousel slide" data-ride="carousel" data-interval="10000">
  <ol class="carousel-indicators">
    <li data-target="#carouselIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselIndicators" data-slide-to="1"></li>
    <li data-target="#carouselIndicators" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner" role="listbox">

    <?php $n = 0; ?>

	@if(isset($modelSlide))
    	@foreach($newModel as $obj)

            @if($n > 0)
                <div class="carousel-item">
            @else
                <div class="carousel-item active">
            @endif
            	<a href="{{ url(Ctm::getModelUrl($obj->id)) }}">
              	<img class="d-block img-fluid" src="{{ Storage::url($obj->model_thumb) }}" alt="slide">
              	<div class="carousel-caption d-none d-md-block">
                	<h3>{{ $obj->name}}＠{{ $obj->school }}</h3>
                </div>
              </a>
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

<!--
    <div class="carousel-item active">
      <img class="d-block img-fluid" src="/storage/article/1/thumbnail/items_1.jpg" alt="slide">
      <div class="carousel-caption d-none d-md-block">
        <h3>松山で一番美味しいランチはこれだ！</h3>
        <p>みいたけ＠松山大学</p>
      </div>
    </div>
    <div class="carousel-item">
      <img class="d-block img-fluid" src="/storage/article/1/thumbnail/items_1.jpg" alt="slide">
      <div class="carousel-caption d-none d-md-block">
        <h3>松山で一番美味しいランチはこれだ！</h3>
        <p>みいたけ＠松山大学</p>
      </div>
    </div>
    <div class="carousel-item">
      <img class="d-block img-fluid" src="/storage/article/1/thumbnail/items_1.jpg" alt="slide">
      <div class="carousel-caption d-none d-md-block">
        <h3>松山で一番美味しいランチはこれだ！</h3>
        <p>みいたけ＠松山大学</p>
      </div>
    </div>
-->

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
