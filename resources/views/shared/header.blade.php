<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    {{-- <meta name="viewport" content="width=device-width, initial-scale=1"> --}}
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'GREEN ROCKET') }}</title>

    <!-- Styles -->
    {{--
    <link href="{{ asset('font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    --}}
    
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
    
    @if(Ctm::isAgent('all'))
    <link href="{{ asset('css/style-sp.css') }}" rel="stylesheet">
    @else
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
	@endif

  	<script src="//code.jquery.com/jquery-1.12.4.min.js"></script>
  	<script src="//code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>

</head>
@if(Ctm::isLocal())
<div style="position: relative; bottom:0; z-index:10000; background:red; width: 100%;">
<?php 
echo "aaa";
print_r(session('item.data')); ?>
</div>
@endif

@if(Ctm::isAgent('all'))
<?php exit; ?>

@endif
