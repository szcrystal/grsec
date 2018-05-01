@include('shared.header')
<body>

    <div id="app">
    	@if(Ctm::isAgent('sp'))
			@include('shared.headNavSp')
        @else
        	@include('shared.headNav')
        @endif

		<div class="container wrap-all mt-3">
			<div class="row">
                <?php $className = isset($className) ? $className : ''; ?>
                <div class="flex col-md-12 py-4 {{ $className }}"><!-- offset-md-1-->
                    @yield('content')
                    @yield('leftbar')
                    @yield('rightbar')
                </div>
            </div>

        </div>

    </div>

@include('shared.footer')

</body>
</html>
