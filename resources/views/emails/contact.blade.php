<?php 
/* Here is mail view */
?>

<?php //$info = DB::table('siteinfos')->first(); ?>

<style>
p {
	margin: 0 0 1.1em 0.7em;
}
</style>

@if($isUser)
{{ $data['name'] }} 様
<br><br>
<div>※このメールは配信専用メールのため、ご返信いただけません。</div>
<br>
{!! nl2br($header) !!}
@else
{{ $data['name'] }}様より、お問い合わせがありました。<br />
頂きました内容は下記となります。<br><br>
<a href="{{ url('dashboard/contacts/'. $data['id']) }}">{{ url('dashboard/contacts/'. $data['id']) }}</a>
@endif

<br><br>
<hr>
<br>
【ご希望方法】
<p>
@if($data['is_ask_type'] == 1)
	電話
@elseif($data['is_ask_type'] == 2)
	メール
@endif
</p>

【お問い合わせ種別】
<p>{{ $data['ask_category'] }}</p>

【お名前】
<p>{{ $data['name'] }}</p>

【メールアドレス】
<p>{{ $data['email'] }}</p>

@if($data['is_ask_type'] == 1)
    【電話番号】
    <p>{{ $data['tel_num'] }}</p>

    【ご希望日】
    <p>{{ $data['request_day'] }}</p>

    【ご希望時間帯】
    <p>{{ $data['request_time'] }}</p>
@endif

【お問い合わせ内容】
<p>{!! nl2br($data['comment']) !!}</p>
<br>

<hr>
<br>

@if($isUser)
{!! nl2br($footer) !!}
@endif

<div style="margin:4em 0 2em;">
{!! nl2br($setting->mail_footer) !!}
</div>
<br>

