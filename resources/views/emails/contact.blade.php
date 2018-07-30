<?php 
/* Here is mail view */
?>

<?php //$info = DB::table('siteinfos')->first(); ?>

@if($isUser)
{{ $data['name'] }} 様
<br>
<p>※このメールは配信専用メールのため、ご返信いただけません。</p>
<br>
{!! nl2br($header) !!}
@else
{{ $data['name'] }}様より、お問い合わせがありました。<br />
頂きました内容は下記となります。<br><br>
<a href="{{ url('dashboard/contacts/'. $data['id']) }}">{{ url('dashboard/contacts/'. $data['id']) }}</a>
@endif

<br /><br />
<hr>
<br>
◆お問い合わせ種別<br />
{{ $data['ask_category'] }}<br /><br />

◆お名前<br />
{{ $data['name'] }}<br /><br />

◆メールアドレス<br />
{{ $data['email'] }}<br /><br />

◆お問い合わせ内容<br />
{!! nl2br($data['comment']) !!}

<br><br>
<hr>
<br>
@if($isUser)
{!! nl2br($footer) !!}
@endif

<br><br>
{!! nl2br($setting->mail_footer) !!}

<br><br>

