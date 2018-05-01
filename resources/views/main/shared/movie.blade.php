@if(isset($atcl->yt_id))
	<?php
        $url = explode('/', $atcl->movie_url); //$url = 'http://www.nicovideo.jp/watch/sm19026423';
        $embed = end($url);
        if($embed == '') {
            $embed = array_slice($url, -2, 1);
            $embed = $embed[0];
        }
        
        $width = Ctm::isAgent('sp') ? '100%' : 640;
    ?>

    @if(strpos($atcl->movie_url, 'vimeo') !== FALSE)
        <iframe src="https://player.vimeo.com/video/{{ $embed }}?color=03a5fc&title=0&portrait=0" width="{{ $width }}" height="360" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>

    @elseif(strpos($atcl->movie_url, 'nico') !== FALSE)
        <script type="text/javascript" src="http://ext.nicovideo.jp/thumb_watch/{{ $embed }}"></script>
        {{-- <noscript><a href="http://www.nicovideo.jp/watch/sm19026423">【ニコニコ動画】また☆一人ディズニー【ランド編】</a></noscript> --}}

    @elseif(strpos($atcl->movie_url, 'youtube') !== FALSE)
        <?php
        	$embed = explode('=', $atcl -> movie_url); //https://youtu.be/1oeN1gmLzvM
        	$embed = $embed[1];
        ?>
        
        <iframe width="{{ $width }}" height="360" src="https://www.youtube.com/embed/{{ $embed }}" frameborder="0" allowfullscreen></iframe>
    @endif
@endif
