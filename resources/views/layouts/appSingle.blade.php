@include('shared.header')
<body>

    <div id="app">
        @if(Ctm::isAgent('sp'))
			@include('shared.headNavSp')
        @else
        	@include('shared.headNav')
        @endif

		<div class="container wrap-all single">
        	@yield('content')
            @if(Ctm::isAgent('sp'))
            	@include('main.shared.leftbar')
            @endif
        </div>


    </div>


@include('shared.footer')

</body>
</html>
