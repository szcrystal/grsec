@extends('layouts.app')

@section('content')

<div id="main" class="fix-page col-md-12 {{ $fix->slug }}">

    <div class="panel panel-default">
        <h2 class="h2 mb-3 card-header">{{ $fix->title }}</h2>

        <div class="panel-body">

            <div class="top-cont clearfix">


<div class="border border-secondary p-2">
<img src="https://image.rakuten.co.jp/shop8463/cabinet/00839795/01382757/img58114823.gif" alt="初めにお読み下さい" width="170" height="30"><br />
<p style="font-weight:bold; margin:10px 0 0;">
<span style="color:#9C9; margin:0 3px 0 0;">●</span>植物は生き物です。</p>
<p style="margin:0;">工業製品ではありませんので管理方法や環境によって生育状況が変わります。<br />
具合が悪くなったりすることもありますが管理次第で元気にもなります。<br />
植え付け後の生育はお客様次第です。<br />
是非それぞれの環境の中で面倒を見、末永く可愛がってあげてください。</p>
<p style="font-weight:bold; margin:10px 0 0;">
<span style="color:#9C9; margin:0 3px 0 0;">●</span>植物の配送</p>
<p style="margin:0;">梱包・配送には万全を期しておりますが、商品の特性上、配送による若干の枝折れや痛みがでる場合があります。<br />
ご理解のうえご了承いただけますようよろしくお願い致します。</p>
</div>

<section>
<img src="https://image.rakuten.co.jp/shop8463/cabinet/00839795/01382757/img58114824.gif" width="578" height="30">
<h3>ご利用前・ご注文後のよくあるご質問とご不安な点</h3>
<div>
<h4><img src="https://image.rakuten.co.jp/shop8463/cabinet/00839795/01382757/img58114269.gif" width="12" height="12">商品について</h4>
<ul class="triangle">
<li><a href="https://www.rakuten.ne.jp/gold/shop8463/qa1.html#1">植木や下草を育てるのは難しい？</a></li>
<li><a href="https://www.rakuten.ne.jp/gold/shop8463/konpo/konpo_sagyou.html">植木はどんな状態で届くの？（植木の梱包状態）</a></li>
<li><a href="https://www.rakuten.ne.jp/gold/shop8463/syokusaihou/mizuyari/mizuyari.html">水やりってどのくらいの頻度でやるの？</a></li>
<li><a href="https://www.rakuten.ne.jp/gold/shop8463/qa8.html#18">ポットと根巻きの違いは？</a></li>
<li><a href="https://www.rakuten.ne.jp/gold/shop8463/qa8.html#2">商品が到着したら何日ぐらいで植えるべき？</a></li>
<li><a href="https://www.rakuten.ne.jp/gold/shop8463/qa3.html#10">届く木の重さってどれぐらい？</a></li>
<li><a href="https://www.rakuten.ne.jp/gold/shop8463/qa2.html#12">どれぐらいの穴を掘ればいいの？</a></li>
<li><a href="https://www.rakuten.ne.jp/gold/shop8463/qa3.html#1">植えつけ適期は4月じゃないの？（常緑樹・落葉樹）</a></li>
<li><a href="https://www.rakuten.ne.jp/gold/shop8463/qa8.html#19">届いてからすぐ植えない場合、梱包はとったほうがいいの？</a></li>
<li><a href="https://www.rakuten.ne.jp/gold/shop8463/qa2.html#16">雪と霜が心配なんだけど植えても大丈夫？</a></li>
<li><a href="https://www.rakuten.ne.jp/gold/shop8463/qa1.html#16">1年にどれぐらい伸びますか？最終的にどれぐらいになる？</a></li>
</ul>
</div>


<div>
<h4><img src="https://image.rakuten.co.jp/shop8463/cabinet/00839795/01382757/img58114269.gif" width="12" height="12"><b>ご注文について</b></h4>

<ul class="triangle">
<li><a href="https://www.rakuten.co.jp/howtobuy/step1.html">ご注文方法</a></li>

<li><a href="https://www.rakuten.ne.jp/gold/shop8463/qa4.html#3">ご注文内容の確認について</a></li>
<li><a href="https://www.rakuten.co.jp/shop8463/info.html#nagare_1">ご注文から発送までの流れ</a></li>
<li><a href="https://www.rakuten.ne.jp/gold/shop8463/qa4.html">ご注文についてよくあるご質問</a></li>
</ul>
</div>

<div>
<h4><img src="https://image.rakuten.co.jp/shop8463/cabinet/00839795/01382757/img58114269.gif" width="12" height="12">お支払いについて</h4>
<ul class="triangle">
<li><a href="https://www.rakuten.co.jp/shop8463/info2.html">お支払い方法について</a></li>
<li><a href="https://www.rakuten.ne.jp/gold/shop8463/qa5.html">お支払いについてよくあるご質問</a></li>
<ul>
</div>

<div>
<h4><img src="https://image.rakuten.co.jp/shop8463/cabinet/00839795/01382757/img58114269.gif" width="12" height="12">配送について</h4>
<ul class="triangle">
<li><a href="https://www.rakuten.co.jp/shop8463/info.html#delivery_0">配送業者について</a></li>
<li><a href="https://www.rakuten.co.jp/shop8463/info.html#otodokebi">発送からお届けまでの日数について</a></li>
<li><a href="https://www.rakuten.co.jp/shop8463/info2.html#delivery_2">送料について</a></li>
<li><a href="https://www.rakuten.co.jp/shop8463/info.html#doukonpou">下草・コニファーの同梱包について</a></li>
<li><a href="#guide_2">最短日について</a></li>
<li><a href="#guide_2">午前中配送不可エリアについて</a></li>
<li><a href="https://www.rakuten.ne.jp/gold/shop8463/qa6.html">配送についてよくあるご質問</a></li>
</ul>
</div>

<div>
<h4><img src="https://image.rakuten.co.jp/shop8463/cabinet/00839795/01382757/img58114269.gif" width="12" height="12">返品・交換・キャンセル・保証について</h4>
<ul class="triangle">
<li><a href="https://www.rakuten.co.jp/shop8463/info.html#repayment">商品の返品・交換・キャンセルについて</a></li>
<li><a href="https://www.rakuten.ne.jp/gold/shop8463/qa9.html#14">返金について</a></li>
<li><a href="https://www.rakuten.ne.jp/gold/shop8463/karehosyou.html">6ヶ月間の枯れ保証</a></li>
</ul>
</div>

<div>
<h4><img src="https://image.rakuten.co.jp/shop8463/cabinet/00839795/01382757/img58114269.gif" width="12" height="12"><a href="https://www.rakuten.ne.jp/gold/shop8463/qa1.html">よくあるご質問（Q＆A）</a></h4>
</div>


<div>
<h4><img src="https://image.rakuten.co.jp/shop8463/cabinet/00839795/01382757/img58114269.gif" width="12" height="12">その他全般</h4>
<ul class="triangle">
<li><a href="https://www.rakuten.co.jp/shop8463/info2.html#delivery_2">送料はどれぐらいかかるの？</a></li>
<li><a href="https://www.rakuten.ne.jp/gold/shop8463/karehosyou.html">枯れたら保証はあるの？</a></li>
<li><a href="https://www.rakuten.ne.jp/gold/shop8463/qa3.html#13">商品の取り置きは可能？</a></li>
<li><a href="https://www.rakuten.ne.jp/gold/shop8463/qa11.html#3">HPにのってない商品の取り扱いはある？</a></li>
<li><a href="https://www.rakuten.ne.jp/gold/shop8463/qa3.html#14">商品の予約はできる？</a></li>
<li><a href="https://www.rakuten.ne.jp/gold/shop8463/qa3.html#14">入荷の際に連絡してもらえますか？</a></li>
</ul>
</div>

<div>
<h4><img src="https://image.rakuten.co.jp/shop8463/cabinet/00839795/01382757/img58114269.gif" width="12" height="12">問い合わせ方法</h4>
<ul class="triangle">
<li><a href="#guide_3">メールでのお問い合わせ</a></li>
<li><a href="#guide_3">お電話でのお問い合わせ</a></li>
</ul>
</div>

<div>
<h4><img src="https://image.rakuten.co.jp/shop8463/cabinet/00839795/01382757/img58114269.gif" width="12" height="12">キャンペーンについて</h4>
<ul class="triangle">
<li><s><a href="https://shop.plaza.rakuten.co.jp/shop8463/diary/detail/201209250000/">お庭の写真で20％オフ割引券プレゼント！</a></s></li>
<!--// <td><a href="https://item.rakuten.co.jp/shop8463/c/0000000214/">お庭の写真で20％オフ割引券プレゼント！</a></li> //-->
</ul>
</div>

<div>
<h4><img src="https://image.rakuten.co.jp/shop8463/cabinet/00839795/01382757/img58114269.gif" width="12" height="12">管理・メンテナンス方法</h4>
<ul class="triangle">
<li><a href="https://www.rakuten.ne.jp/gold/shop8463/syokusaihou/syokusai_home.html">植えつけ方法</a></li>
<li><a href="https://www.rakuten.ne.jp/gold/shop8463/syokusaihou/mizuyari/mizuyari.html">水やりの方法</a></li>
<li><a href="https://www.rakuten.ne.jp/gold/shop8463/syokusaihou/syokusai_ho.html#sityu_ho">支柱のかけ方</a></li>
</ul>
</div>

<div>
<h4><img src="https://image.rakuten.co.jp/shop8463/cabinet/00839795/01382757/img58114269.gif" width="12" height="12">商品のご予約お取り置きについて</h4>
<li><a href="https://www.rakuten.ne.jp/gold/shop8463/qa3.html#14">商品のご予約と入荷時のご連絡について</a></li>
<li><a href="https://www.rakuten.ne.jp/gold/shop8463/qa3.html#13">商品のお取り置きについて</a></li>
</ul>
</div>

<div>
<h4><img src="https://image.rakuten.co.jp/shop8463/cabinet/00839795/01382757/img58114269.gif" width="12" height="12">その他</h4>
<ul class="triangle">
<li><a href="https://www.rakuten.ne.jp/gold/shop8463/qa11.html#1">メールの返信がこない場合</a></li>
<li><a href="#guide_5">その他のご注意</a></li>
</ul>
</div>


<section>
<h3><img src="https://image.rakuten.co.jp/shop8463/cabinet/00839795/01382757/img58114825.gif" width="400" height="28"></h3>

<div>
    <h5 style="background:#FFF5EC;"><img src="https://image.rakuten.co.jp/shop8463/cabinet/00839795/01382757/img58114271.gif" width="18" height="18" align="absmiddle">最短日について</h5>
    <p>ご注文の際、備考欄に「最短日」とご記入いただきますとお届け可能な最短日時をこちらでご指定し出荷いたします。<br />
ご希望の時間帯指定がある場合は、時間帯のみご指定下さい。<br />
※日付欄は必ず空欄のままにして下さい。 </p>
</div>

<div>
<h5 style="background:#FFF5EC;"><img src="https://image.rakuten.co.jp/shop8463/cabinet/00839795/01382757/img58114271.gif" width="18" height="18" align="absmiddle">午前中配送不可エリアについて</h5>
<p>佐川急便さん、西濃運輸さんの配送エリアには午前中配送ができないエリアがございます。<br />
こちらのエリアは午後便のみとなり、佐川急便さんは16時～18時より、西濃運輸は13時～17時のお届けとなります。<br />
ご不便をおかけしますが予めご了承下さい。<br>
&gt;&gt;<a href="https://www.rakuten.ne.jp/gold/shop8463/qa6.html">配送についてよくある質問はこちら</a>
</p>
</div>

<div>
<h5 style="background:#FFF5EC;"><img src="https://image.rakuten.co.jp/shop8463/cabinet/00839795/01382757/img58114271.gif" width="18" height="18" align="absmiddle">決済方法別のお届けまでの目安</h5>

<table style="font-size:13px; color:#000;" width="100%" cellpadding="2" cellspacing="0" border="1">
<tr>
<th bgcolor="#dddddd">決済方法</th>
<td>クレジットカード<br />・代金引換<br /><font color="red"><b>最速<i>！</i></b></font></td>
<td>銀行振込</td>
<td colspan="2">楽天バンク決済</td>
<td>コンビニ決済</td>
<td>ペイジー</td>
</tr>
<tr>
<th bgcolor="#dddddd">ご注文(昼12時まで)</th>
<td>受付<br /><font color="blue">即日発送</font></td>
<td>受付・ご入金お願い<br />メール送信  (当店)</td>
<td>受付<br />残高確認・振替</td>
<td>受付<br />増額金額変更の場合<br />メール送信 (当店)</td>
<td>受付<br />支払受付番号、払込票URLを<br />メール送信 (当店)</td>
<td>受付<br />お支払いURLを<br />メール送信  (当店)</td>
</tr>
<tr>
<th bgcolor="#dddddd">翌　日</th>
<td bgcolor="#aed7d6">お届け<br />[東日本]</td>
<td>ご入金<br />(お客様)</td>
<td>ご入金確認<br /><font color="blue">発送</font></td>
<td>変更承認の操作<br />・ご入金(お客様)</td> 
<td>払込票の印刷<br />CVSでお支払い<br />(お客様)</td>
<td>ご入金<br />(お客様)</td>
</tr>
<tr>
<th bgcolor="#dddddd">２日後</th>
<td bgcolor="#78d24d">お届け<br />[北海道・西日本]</td>
<td>ご入金確認<br /><font color="blue">発送</font></td>
<td bgcolor="#aed7d6">お届け<br />[東日本]</td>
<td>ご入金確認<br /><font color="blue">発送</font></td>
<td>ご入金確認<br /><font color="blue">発送</font></td>
<td>ご入金確認<br /><font color="blue">発送</font></td>
</tr>
<tr>
<th bgcolor="#dddddd">３日後</th>
<td bgcolor="#ccff00">お届け<br />[沖縄]</td>
<td bgcolor="#aed7d6">お届け<br />[東日本]</td>
<td bgcolor="#78d24d">お届け<br />[北海道・西日本]</td>
<td bgcolor="#aed7d6">お届け<br />[東日本]</td>
<td bgcolor="#aed7d6">お届け<br />[東日本]</td>
<td bgcolor="#aed7d6">お届け<br />[東日本]</td>
</tr>
<tr>
<th bgcolor="#dddddd">４日後</th>
<td></td>
<td bgcolor="#78d24d">お届け<br />[北海道・西日本]</td>
<td bgcolor="#ccff00">お届け<br />[沖縄]</td>
<td bgcolor="#78d24d">お届け<br />[北海道・西日本]</td>
<td bgcolor="#78d24d">お届け<br />[北海道・西日本]</td>
<td bgcolor="#78d24d">お届け<br />[北海道・西日本]</td>
</tr>
<tr>
<th bgcolor="#dddddd">５日後</th>
<td></td>
<td bgcolor="#ccff00">お届け<br />[沖縄]</td>
<td></td>
<td bgcolor="#ccff00">お届け<br />[沖縄]</td>
<td bgcolor="#ccff00">お届け<br />[沖縄]</td>
<td bgcolor="#ccff00">お届け<br />[沖縄]</td>
</tr>
</table>
※上表は、佐川急便でお届けする商品(1.5m以上の植木)の目安です。クロネコヤマトでお届けする商品(下草・果樹・コニファー・1.4m以下の植木)の場合は、翌日お届け可能な地域が上表より広がります。<br />
※次の場合は、誠に申し訳ございませんがお届け予定日が後にずれてまいります。<br />
<ul style="font-size:13px; color:#666; margin:0;"> 
<li>お客様からのご入金やお支払の確認ができない場合</li> 
<li>クレジットカード決済で、与信エラーもしくは与信保留となった場合</li> 
<li>商品の欠品、梱包数の変更による送料訂正があった場合</li> 
<li>その他、お客様情報やご注文内容に不明点がある場合など、お届けに必要な情報不備の場合</li> 
<li>自然災害等により交通に支障が生じ配送が困難な場合</li> 
</ul>
</div>

</section>

<section>
<h3><img src="https://image.rakuten.co.jp/shop8463/cabinet/00839795/01382757/img58114827.gif" width="400" height="28"></h3>

<div>
<h5 style="background:#FFF5EC;"><img src="https://image.rakuten.co.jp/shop8463/cabinet/00839795/01382757/img58114271.gif" width="18" height="18" align="absmiddle">メールでのお問い合わせ</h5>
<p>24時間受付をしております。ご連絡先：<a href="mailto:info@green-rocket.jp">info@green-rocket.jp</a><br />
店休日の前日17時以降にいただきましたお問い合わせの返信は、原則休み明けに
なります。</p>
</div>
 
<div>
<h5 style="background:#FFF5EC;"><img src="https://image.rakuten.co.jp/shop8463/cabinet/00839795/01382757/img58114271.gif" width="18" height="18" align="absmiddle">電話でのお問い合わせ</h5>
<p>営業時間内のご対応になります。<br>
ご連絡先　0299-53-0030<br />
当店営業時間　月～土8:00～17:00（日、祝日除く）</p>
</div>
</section>
                {!! $fix->contents !!}
            </div>

		</div>

    </div>


</div>

@endsection


@section('leftbar')
    @include('main.shared.leftbar')
@endsection






