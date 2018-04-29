
{{ $name }} さん
<br /><br />

▼パスワードリセット用のリンクは下記となります。<br />
{{ url('password/reset/'. $token) }}
<br /><br />

有効時間の{{ config('auth.expire') }}分以内にクリックをしてパスワードをリセットして下さい。

<br /><br /><br /><br />


___________________________
<br>
{{ env('ADMIN_NAME', 'MovieReview') }}
