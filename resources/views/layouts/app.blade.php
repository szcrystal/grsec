@include('shared.header')
<body>

<div id="app">
            
    @if(Ctm::isAgent('sp'))
        @include('shared.headNavSp')
    @else
        @include('shared.headNav')
    @endif

<div class="sp-fix-wrap">
    
    @yield('belt')
    
    
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
