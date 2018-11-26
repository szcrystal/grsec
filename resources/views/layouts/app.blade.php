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

</body>
</html>
