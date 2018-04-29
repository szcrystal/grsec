<?php 
/* Here is mail view */
?>

<?php //$info = DB::table('siteinfos')->first(); ?>

@if($is_user)
{{$user_name}}　様
<br /><br />
お問い合わせの送信が完了しました。<br>
頂きました内容は下記となります。

{{--
{!! nl2br($info->mail_contact) !!}
--}}

<br /><br />
………………………………………………………………………………………
<br /><br />

{{--
◆お問い合わせカテゴリー<br />
{{$ask_category}}<br /><br />

@if(isset($delete_id))
◆削除依頼記事ID<br />
{{$delete_id}}<br /><br />

◆削除依頼記事タイトル<br />
{{$atclTitle}}<br /><br />
@endif


◆お名前<br />
{{$user_name}}<br /><br />

◆メールアドレス<br />
{{$user_email}}<br /><br />



◆お問い合わせ内容<br />
{!! nl2br($context) !!}
<br /><br /><br /><br />

{{--
{!! nl2br($info->mail_footer) !!}
--}}
<br /><br />

@else
{{$user_name}}様より、お問い合わせがありました。<br />
頂きました内容は下記となります。<br />

<br />
………………………………………………………………………………………
<br /><br />

◆お問い合わせカテゴリー<br />
{{$ask_category}}<br /><br />

@if(isset($delete_id))
◆削除依頼記事ID<br />
{{$delete_id}}<br /><br />

◆削除依頼記事タイトル<br />
{{$atclTitle}}<br /><br />
@endif

◆お名前<br />
{{$user_name}}<br /><br />

◆メールアドレス<br />
{{$user_email}}<br /><br />

◆お問い合わせ内容<br />
{!! nl2br($context) !!}
<br /><br /><br /><br />
--}}


{{--
{!! nl2br($info->mail_footer) !!}
--}}

<br /><br />

@endif
