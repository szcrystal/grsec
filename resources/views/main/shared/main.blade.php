<div class="main-list clearfix">
<?php
    use App\User;
    use App\Category;
    use App\FeatureCategory;
?>

<section class="top-cont feature clear">
<h2>特集</h2>
    @foreach($features as $feature)
    <article style="background-image:url({{Storage::url($feature->thumb_path)}})" class="float-left">

            <a href="{{ url(Ctm::getAtclUrl($feature->id)) }}">

            @if($feature->thumb_path == '')
                <span class="no-img">No Image</span>
            @else
                <div class="main-thumb"></div>
            @endif

            <?php
                $num = Ctm::isAgent('sp') ? 30 : 18;
            ?>

            <div class="meta">
            	<h3>{{ $feature->title }}</h3>
                {{-- <p>{{ User::find($feature->model_id)->name }}</p> --}}
            </div>
        </a>
    </article>
    @endforeach
</section>


<section class="temporary">
</section>

<section class="temporary">
</section>


    @foreach($atcls as $key => $obj)
    	<section class="top-cont atcl clear">
		<h2>{{ $key }}</h2>
		<div class="clear">
    	@foreach($obj as $atcl)
            <article style="background-image:url({{Storage::url($atcl->thumb_path)}})">

                <a href="{{ url(Ctm::getAtclUrl($atcl->id)) }}">

                @if($atcl->thumb_path == '')
                    <span class="no-img">No Image</span>
                @else
                    <div class="main-thumb"></div>
                @endif


                <?php
                    $num = Ctm::isAgent('sp') ? 30 : 18;
                ?>

                <div class="meta">
                    <h3>{{ $atcl->title }}</h3>
                    <p>{{ User::find($atcl->model_id)->name }}</p>
                </div>
                </a>
            </article>
    	@endforeach
		</div>
        </section>
    @endforeach



</div>


{{-- $atcls->links() --}}



