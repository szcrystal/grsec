<?php 
/* Here is mail view */
?>

<?php //$info = DB::table('siteinfos')->first(); ?>

@if($is_user)
{{$name}} 様
<br>
<p>※このメールは配信専用メールのため、ご返信いただけません。</p>
<br>
{!! nl2br($header) !!}
@else
{{$name}}様より、お問い合わせがありました。<br />
頂きました内容は下記となります。<br><br>
<a href="{{ url('dashboard/contacts/'. $id) }}">{{ url('dashboard/contacts/'. $id) }}</a>
@endif

<br /><br />
………………………………………………………………………………………
<br /><br />

◆お問い合わせカテゴリー<br />
{{$ask_category}}<br /><br />

◆お名前<br />
{{$name}}<br /><br />

◆メールアドレス<br />
{{$email}}<br /><br />

◆お問い合わせ内容<br />
{!! nl2br($comment) !!}

<br /><br />
………………………………………………………………………………………
<br /><br />

@if($is_user)
{!! nl2br($footer) !!}
@endif

<br /><br /><br />

{!! nl2br($mail_footer) !!}

<br /><br />

