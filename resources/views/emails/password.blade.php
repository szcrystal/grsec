
{{ $name }} 様
<br /><br />
グリーンロケットです。<br>
パスワードリセットのリクエストを受け付けました。<br><br>
▼パスワードリセット用のリンクは下記となります。<br>
{{ url('password/reset/'. $token) }}
<br /><br />

このリンクの有効時間は{{ config('auth.expire') }}分となります。<br>
{{ config('auth.passwords.users.expire') }}以内にクリックをしてパスワードをリセットして下さい。

<br /><br /><br />


<?php
use App\Setting;
$setting = Setting::get()->first();
?>
{{ $setting->mail_footer }}
