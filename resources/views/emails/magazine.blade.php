<?php 
/* Here is mail view */
?>

<?php //$info = DB::table('siteinfos')['first(); ?>


{{ $data['name'] }} 様

<br><br>

{!! nl2br($data['contents']) !!}

<br><br>
<br><br><br><br><br>

◎配信停止について<br>
メールマガジンの配信を解除するには、こちらのページより設定して下さい。<br>
https://green-rocket.jp/mypage
<br><br>
＊ご利用にはログインが必要です。
<br>


<br><br><br>
{!! nl2br($setting->mail_footer) !!}


