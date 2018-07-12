<?php 
/* Here is mail view */
?>

<?php //$info = DB::table('siteinfos')['first(); ?>


{{ $data['name'] }} 様

<br><br>

{!! nl2br($data['contents']) !!}

<br><br>
<br><br>


{{--
{!! nl2br( $footer ) !!}
--}}

<br><br><br>
{!! nl2br($setting->mail_footer) !!}


