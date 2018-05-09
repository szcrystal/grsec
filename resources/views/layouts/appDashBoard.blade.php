@include('dashboard.shared.head')

<body class="fixed-nav sticky-footer bg-dark" id="page-top">

@include('dashboard.shared.nav')



		<div class="content-wrapper bg-midLight">
    		<div class="container-fluid mb-5 pb-3">
            	@yield('content')
            </div>
        </div>



@include('dashboard.shared.foot')

</body>
</html>
