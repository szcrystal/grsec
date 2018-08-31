@include('shared.header')
<body>

    <div id="app">
    	{{--
    	@if(Auth::check())
     		@include('shared.authNav')
     	@endif
      --}}   
            
    	@if(Ctm::isAgent('sp'))
			@include('shared.headNavSp')
        @else
        	@include('shared.headNav')
        @endif
        
        
        @if(isset($isTop) && $isTop)
            <div class="tophead-wrap">
                <div class="clearfix">
                    {!! nl2br($newsCont) !!}
                </div>

                @include('main.shared.carousel')
            </div>
        @endif

		<div class="container">

            <?php $className = isset($className) ? $className : ''; ?>
            
            <div class="pb-4 wrap-all clearfix {{ $className }}"><!-- offset-md-1-->
                @yield('content')
                @yield('leftbar')
            </div>
        </div>

    </div>

@include('shared.footer')

</body>
</html>
