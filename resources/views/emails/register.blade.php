<?php 
/* Here is mail view */
?>

ようこそ、{{$name}} さん
<br /><br />
ユーザー登録はまだ完了しておりません。<br>
▼以下のリンクをクリックしてユーザーを有効化して下さい。<br />
<a href="{{ url('register/confirm/'. $confirm_token.'?uid='. $user_id)}}">{{ url('register/confirm/'. $confirm_token.'?uid='.$user_id)}}</a>
<br /><br /><br />
<br /><br /><br />

_______________________________________
<br>
{{ env('ADMIN_NAME', 'MovieReview') }}

<br /><br />

