@include('shared.header')
<body>

<div id="app">
            
    @if(Ctm::isAgent('sp'))
        @include('shared.headNavSp')
    @else
        @include('shared.headNav')
    @endif

<div class="fix-wrap">
    
    {{-- @yield('belt') --}}
    
    @if(isset($type) && $type == 'single')
        @if(! Ctm::isAgent('sp'))
            @include('main.shared.news')
        @endif
    @else
    	@include('main.shared.news')
    @endif
    
    <div class="container">
    
        <?php $className = isset($className) ? $className : ''; ?>
        
        <div class="pb-4 wrap-all clearfix {{ $className }}"><!-- offset-md-1-->
            @yield('bread')
            @yield('content')
            @yield('leftbar')
        </div>
    </div>

@include('shared.footer')
</div><!-- for sp-fix-wrap -->
</div><!-- id app -->

<?php
    $getNow = '';
    $getNow = '?up=' . time();
?>

<!-- Scripts -->
{{-- integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" --}}
<script src="https://code.jquery.com/jquery-3.2.1.min.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

@if(! Ctm::isAgent('sp'))
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/js/lightbox.min.js" type="text/javascript"></script>
@endif

<script type="text/javascript" src="//jpostal-1006.appspot.com/jquery.jpostal.js"></script>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>



<script src="{{ asset('js/script.js' . $getNow) }}"></script>

@if(! Ctm::isAgent('sp'))
<script>
    lightbox.option({
    	'fadeDuration': 400,
        'resizeDuration': 500,
    	'positionFromTop': 80,
        'wrapAround': true,
      	'showImageNumberLabel': false,
      	'maxWidth': 800,
    });
</script>
@endif



</body>
</html>
