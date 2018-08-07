@extends('layouts.app')

@section('content')

<div id="main" class="fix-page col-md-12 {{ $fix->slug }}">

    <div class="panel panel-default">
        <h2 class="h2 mb-3 card-header">{{ $fix->title }}</h2>

        <div class="panel-body">

            <div class="top-cont clearfix">



<nav>
<p><b>ご質問カテゴリ</b></p>
<ul class="clearfix">
<li class="float-left"><a href="https://www.rakuten.ne.jp/gold/shop8463/qa1.html">植物の管理</a></li>
<li class="float-left"><a href="https://www.rakuten.ne.jp/gold/shop8463/qa2.html">植え付け</a></li>
<li class="float-left"><a href="https://www.rakuten.ne.jp/gold/shop8463/qa3.html">商品について</a></li>
<li class="float-left"><a href="https://www.rakuten.ne.jp/gold/shop8463/qa4.html">注文方法</a></li>
<li class="float-left"><a href="https://www.rakuten.ne.jp/gold/shop8463/qa5.html">お支払い</a></li>
<li class="float-left"><a href="https://www.rakuten.ne.jp/gold/shop8463/qa6.html">配送方法</a></li>
<li class="float-left"><a href="https://www.rakuten.ne.jp/gold/shop8463/qa7.html">ギフト</a></li>
<li class="float-left"><a href="https://www.rakuten.ne.jp/gold/shop8463/qa8.html">到着後の商品の状態</a></li>
<li class="float-left"><a href="https://www.rakuten.ne.jp/gold/shop8463/qa9.html">返品・交換・枯れ保証</a></li>
<li class="float-left"><a href="https://www.rakuten.ne.jp/gold/shop8463/qa10.html">芝桜について</a></li>
<li class="float-left"><a href="https://www.rakuten.ne.jp/gold/shop8463/qa11.html">その他</a></li>
</ul>
</nav>

<section>
<h3>植物の管理について</h3>

<div id="accordion-1">
  
  <div class="card">
    <div class="card-header" id="headingOne">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          <i class="fas fa-question-circle"></i> 初心者は植木や下草を育てたりするのは難しい？
      </h5>
    </div>

    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion-1">
      <div class="card-body">
        そんな事はありません。確かに管理やメンテナンスは大切ですが、植木庭木や下草等は意外と丈夫でなかなか枯れません。キチンとした植え付け方法をして、半年程度水やりに注意すれば大丈夫です。<br /><br />
植木の植え付け方法や水やりの方法はこちらをご覧ください。<br />
<a href="/howto-uetuke"><i class="fas fa-question-circle"></i> 植木の植え付け方法</a><br />
<a href="/howto-water"><i class="fas fa-question-circle"></i> 水やりの方法</a>
      </div>
    </div>
  </div>
  
  <div class="card">
    <div class="card-header" id="headingTwo">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          <i class="fas fa-question-circle"></i> 植木や下草を鉢植えにして管理したいんだけど？
      </h5>
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion-1">
      <div class="card-body">
        大体の植木や下草は鉢植えにしても可能ですが、鉢植えは乾燥するため、水やりをほぼ毎日行ってください。また乾燥に弱い植木は鉢植えにすると枯れる可能性があります。鉢植えは栄養分が限られる為、露地植えの植物よりも育成が遅かったり弱かったりする場合があります。<br />
尚、当店では鉢植えの場合露地と比べて育成環境が異なるため、一律で枯れ保障の対象となっておりません。ご注意くださいませ。
      </div>
    </div>
  </div>
  
  <div class="card">
    <div class="card-header" id="headingThree">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
           <i class="fas fa-question-circle"></i> 露地植えって？
      </h5>
    </div>
    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion-1">
      <div class="card-body">
        露地とは、地面の事で植木や下草を地中に植える事をそういいます。
      </div>
    </div>
  </div>
  
  <div class="card">
    <div class="card-header" id="headingFour">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
           <i class="fas fa-question-circle"></i> 定期的な肥料は必要？
      </h5>
    </div>
    <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion-1">
      <div class="card-body">
        植え付け直後や葉の色が弱い時などには一時的に肥料を使うとよいと思います。その後、状態が安定しているようであれば、それほど肥料は必要ないと思います。
      </div>
    </div>
  </div>
  
  <div class="card">
    <div class="card-header" id="headingFive">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
           <i class="fas fa-question-circle"></i> 水やりはどのような頻度で？
      </h5>
    </div>
    <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordion-1">
      <div class="card-body">
        植え付け1年目は土の乾燥具合を確かめて、乾いているようであればたっぷりと水を与えます。活動の少ない冬に水やりを頻繁に行うと、逆に根腐れの可能性が出てしまいますので控えるようにします。後は葉の様子などを見て行ってください。2年目以降は自然の雨に任せてみましょう。
      </div>
    </div>
  </div>
  
  <div class="card">
    <div class="card-header" id="headingSix">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
           <i class="fas fa-question-circle"></i> 植木の植え付け適期は4月ではないの？
      </h5>
    </div>
    <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordion-1">
      <div class="card-body">
        植木の植え付け適期は、落葉樹は落葉後から芽吹き始める3月末くらいまで。常緑樹は、3月から6月の間です。弊社の植木はそれ以外の時期でも、根をきちんとつくっていますので植え付けは可能です。
      </div>
    </div>
  </div>
  
  <div class="card mb-1">
    <div class="card-header" id="headingSeven">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
           <i class="fas fa-question-circle"></i> 下草などの植え付け適期はいつ？
      </h5>
    </div>
    <div id="collapseSeven" class="collapse" aria-labelledby="headingSeven" data-parent="#accordion">
      <div class="card-body">
        積雪がある時期や霜の降りる時期は避けた方がよろしいかと思います。それ以外の時期は、大丈夫です。一番良いのは春と秋です。
      </div>
    </div>
  </div>
  
  <div class="card mb-1">
    <div class="card-header" id="headingEight">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
           <i class="fas fa-question-circle"></i> なぜ落葉樹は落葉後が移植適期？
      </h5>
    </div>
    <div id="collapseEight" class="collapse" aria-labelledby="headingEight" data-parent="#accordion-1">
      <div class="card-body">
        木は根と葉のバランスで生命が成り立っています。落葉樹は葉が落ちると根もその役割が無い為、休眠状態に入ります。落葉後に根を切っておけば、春に芽吹く際、木は根の量に合わせて葉を芽吹かせますので、負担が少ない一番の移植適期なのです。
      </div>
    </div>
  </div>
  
  <div class="card mb-1">
    <div class="card-header" id="headingNine">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
           <i class="fas fa-question-circle"></i> なぜ常緑樹は、3月から6月が適期なのですか？
      </h5>
    </div>
    <div id="collapseNine" class="collapse" aria-labelledby="headingNine" data-parent="#accordion-1">
      <div class="card-body">
        常緑樹は常に葉がありますので、冬でも根は動いています。春から梅雨の間は根が活発に動く事で、根つきが良くなります。ですが、理屈は落葉樹と同じですので、十分に根を移植に耐えるように根切りをして細かくしておくことが大切です。
      </div>
    </div>
  </div>
  
  <div class="card mb-1">
    <div class="card-header" id="headingTen">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
           <i class="fas fa-question-circle"></i> 初心者でも簡単に植え付けられる？
      </h5>
    </div>
    <div id="collapseTen" class="collapse" aria-labelledby="headingTen" data-parent="#accordion-1">
      <div class="card-body">
        こちらに掲載している手順で行っていただければ、初心者の方でも植え付けは可能です。本当に多くの方がチャレンジしています。<br><br>
        <a href="/howto-uetuke"><i class="fas fa-angle-double-right"></i> 植木の植え付け方法</a>
      </div>
    </div>
  </div>
  
  <div class="card mb-1">
    <div class="card-header" id="headingEleven">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseEleven" aria-expanded="false" aria-controls="collapseEleven">
           <i class="fas fa-question-circle"></i> 植木や下草の管理は難しいですか？
      </h5>
    </div>
    <div id="collapseEleven" class="collapse" aria-labelledby="headingEleven" data-parent="#accordion-1">
      <div class="card-body">
        専門的知識はほとんど必要ありません。個別ごとの注意事項を守り、定植後1年間はまめな水やりと元気のない様子であれば、適度に油粕などの有機肥料を与えてあげれば枯れ死につながる事はほとんどありません。
      </div>
    </div>
  </div>
  
  <div class="card mb-1">
    <div class="card-header" id="headingTwelve">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseTwelve" aria-expanded="false" aria-controls="collapseTwelve">
           <i class="fas fa-question-circle"></i> 大きくならない植木って？
      </h5>
    </div>
    <div id="collapseTwelve" class="collapse" aria-labelledby="headingTwelve" data-parent="#accordion-1">
      <div class="card-body">
        基本木は必ず大きくなります。成長を止める事は出来ませんが、鉢植えにして成長の速度を遅くしたり、剪定によって高さや広がりを制限することが可能です。※鉢植えに向かない植木もありますので、ご相談ください。
      </div>
    </div>
  </div>
  
  <div class="card mb-1">
    <div class="card-header" id="headingThirteen">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseThirteen" aria-expanded="false" aria-controls="collapseThirteen">
           <i class="fas fa-question-circle"></i> 下草のつるが伸びすぎた場合はどうしたらいいですか？
      </h5>
    </div>
    <div id="collapseThirteen" class="collapse" aria-labelledby="headingThirteen" data-parent="#accordion-1">
      <div class="card-body">
        刈り込みばさみなどで株元から一度バツッと切ってしまうと良いでしょう。そうするとそこから新しいつるが伸び始めます。伸びすぎた時はそのように管理するとよいでしょう。
      </div>
    </div>
  </div>
  
  <div class="card mb-1">
    <div class="card-header" id="headingFourteen">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseFourteen" aria-expanded="false" aria-controls="collapseFourteen">
           <i class="fas fa-question-circle"></i> 素人でも植木の移植は出来ちゃう？
      </h5>
    </div>
    <div id="collapseFourteen" class="collapse" aria-labelledby="headingFourteen" data-parent="#accordion-1">
      <div class="card-body">
        絶対に枯れないように植木を掘り取りして移植するのは難しいです。（やり方を知っていても掘り方の技術と道具が必要な為）プロの方にお願いされる事をオススメします。もしチャレンジする場合は、上記の移植適期の時期にチャレンジしてみてください。
      </div>
    </div>
  </div>
  
  <div class="card mb-1">
    <div class="card-header" id="headingFifteen">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseFifteen" aria-expanded="false" aria-controls="collapseFifteen">
           <i class="fas fa-question-circle"></i> 下草の移植って出来るの？
      </h5>
    </div>
    <div id="collapseFifteen" class="collapse" aria-labelledby="headingFifteen" data-parent="#accordion-1">
      <div class="card-body">
        植木よりは比較的簡単に行えますシャベルやスコップで土ごと根をそっくり持ちあげるようにして掘り取り、根が乾く前に植え付けを行ってください。
      </div>
    </div>
  </div>
  
  <div class="card mb-1">
    <div class="card-header" id="headingSixteen">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseSixteen" aria-expanded="false" aria-controls="collapseSixteen">
           <i class="fas fa-question-circle"></i> 1年にどれぐらい伸びますか？最終的にどれぐらいになる？
      </h5>
    </div>
    <div id="collapseSixteen" class="collapse" aria-labelledby="headingSixteen" data-parent="#accordion-1">
      <div class="card-body">
        植木は大体30㎝～50cm程度だと思われます。<br />
しかしこれは、植物や土壌の環境によりますので大幅に変わる場合があります。<br />
高木植木の露地植え（地面に植付け）は、4m～5m程度になるのは間違いないので、あらかじめその状況を見越して植えられることをオススメします。
      </div>
    </div>
  </div>
  
</div>
</section>


<section>
<h3>植え付け環境について</h3>

<div id="accordion-2">
  <div class="card">
    <div class="card-header" id="heading-17">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-17" aria-expanded="true" aria-controls="collapse-17">
          <i class="fas fa-question-circle"></i> 植え付けをする際、最低限必要な肥料は？
      </h5>
    </div>

    <div id="collapse-17" class="collapse" aria-labelledby="heading-17" data-parent="#accordion-2">
      <div class="card-body">
        もし植え付けをするお庭に他の植物が植えられていて元気に生きているとしたら、そのお庭の土壌には最低限必要な栄養素が含まれている事が分かります。そのような環境であればとり急ぎ肥料などは必要ありません。植物を植えて成長が悪いようであれば肥料を与えるようにしてください。
      </div>
    </div>
  </div>
  
  <div class="card">
    <div class="card-header" id="heading-18">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-18" aria-expanded="false" aria-controls="collapse-18">
          <i class="fas fa-question-circle"></i> 一から植物を植え始めるので土壌環境が分からない？
      </h5>
    </div>
    <div id="collapse-18" class="collapse" aria-labelledby="heading-18" data-parent="#accordion-2">
      <div class="card-body">
        土が黒土や赤土で土自体に問題がなさそうであれば、「腐葉土」と「油粕などの有機肥料」があれば十分です。掘り起こした土に腐葉土2割、有機肥料少々を混ぜて植え付けます。その後成長が悪そうであれば、木の根元や下草の株元に追肥を行います。
      </div>
    </div>
  </div>
  
  <div class="card">
    <div class="card-header" id="heading-19">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-19" aria-expanded="false" aria-controls="collapse-19">
           <i class="fas fa-question-circle"></i> 肥料ってどんなもの？
      </h5>
    </div>
    <div id="collapse-19" class="collapse" aria-labelledby="heading-19" data-parent="#accordion-2">
      <div class="card-body">
        一般的に肥料には化成肥料と有機肥料というものがあります。簡単に言うと化成肥料は人工的に作られて効き目が強いものが多い、有機肥料というのは鶏糞や油粕などで緩効性のものが多いです。なるべくなら緩効性の有機肥料を使うのが望ましいです。コニファー類は化成肥料を好みますので化成肥料を与えると発色が良くなります。
      </div>
    </div>
  </div>
  
  <div class="card">
    <div class="card-header" id="heading-20">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-20" aria-expanded="false" aria-controls="collapse-20">
           <i class="fas fa-question-circle"></i> 腐葉土ってどんなもの？肥料の役割？
      </h5>
    </div>
    <div id="collapse-20" class="collapse" aria-labelledby="heading-20" data-parent="#accordion-2">
      <div class="card-body">
        腐葉土は葉を発酵させて腐らせたもので、主に土壌内の通気性と保湿性を良くし、根を張り巡らせ易いようにします。山の土がふかふかしているのは腐葉土が多く含まれている為です。腐葉土自体に栄養分はありません。腐葉土の代わりにバークたい肥を用いることもあります。
      </div>
    </div>
  </div>
  
  <div class="card">
    <div class="card-header" id="heading-21">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-21" aria-expanded="false" aria-controls="collapse-21">
           <i class="fas fa-question-circle"></i> どんな土を買えばいい？
      </h5>
    </div>
    <div id="collapse-21" class="collapse" aria-labelledby="heading-21" data-parent="#accordion-2">
      <div class="card-body">
        土の入れ替えをする際は黒土か赤土が望ましいです。どちらでも大丈夫です。
      </div>
    </div>
  </div>
  
  <div class="card">
    <div class="card-header" id="heading-22">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-22" aria-expanded="false" aria-controls="collapse-22">
           <i class="fas fa-question-circle"></i> 植える場所が粘土質で水はけが悪そうなのですがそのままでも大丈夫？
      </h5>
    </div>
    <div id="collapse-22" class="collapse" aria-labelledby="heading-22" data-parent="#accordion-2">
      <div class="card-body">
        できれば木を植える周辺の土だけでも入れ替えていただきたいです。もしそれが不可能であれば、木を5cm程高植えしてください。粘土質の土は、水そのものと考えても良いので、高植えの方が望ましいです。
      </div>
    </div>
  </div>
  
  <div class="card mb-1">
    <div class="card-header" id="heading-23">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-23" aria-expanded="false" aria-controls="collapse-23">
           <i class="fas fa-question-circle"></i> 粘土質の所に植える場合はどのような対応が望ましい？
      </h5>
    </div>
    <div id="collapse-23" class="collapse" aria-labelledby="heading-23" data-parent="#accordion-2">
      <div class="card-body">
        出来れば鉢やポットの周辺だけでも土を入れ替えてあげるのが望ましいです。鉢やポットの1.5倍～2倍程度の穴を掘り、そこに赤土か黒土と腐葉土１～3割を入れます。土が足りなければ掘り上げた土と混ぜ合わせます。こうするだけでも土質はかなり変わります。土が無ければ、腐葉土だけでも混ぜるようにしてください。
      </div>
    </div>
  </div>
  
  <div class="card mb-1">
    <div class="card-header" id="heading-24">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-24" aria-expanded="false" aria-controls="collapse-24">
           <i class="fas fa-question-circle"></i> 市販の培養土は有効？
      </h5>
    </div>
    <div id="collapse-24" class="collapse" aria-labelledby="heading-24" data-parent="#accordion-2">
      <div class="card-body">
        培養土と名がつくものは、植物を育てる為の土なので有効であると考えられます。メーカーさんによって土の代わりに使うもの、土と混ぜて肥料として使うものと別れるようですので、店員さんなどに確かめるようにしてください。
      </div>
    </div>
  </div>
  
  <div class="card mb-1">
    <div class="card-header" id="heading-25">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-25" aria-expanded="false" aria-controls="collapse-25">
           <i class="fas fa-question-circle"></i> 土の中から、石やガラがたくさん出てきたのですが大丈夫ですか？
      </h5>
    </div>
    <div id="collapse-25" class="collapse" aria-labelledby="heading-25" data-parent="#accordion-2">
      <div class="card-body">
        本来であれば周辺だけでも土の入れ替えをして頂いた方がよろしいかと思います。ですが、街路樹などはそのような環境で植えられていても元気に育っているものもあります。心配であれば、小さなものから挑戦してみるもの手だと思います。
      </div>
    </div>
  </div>
  
  <div class="card mb-1">
    <div class="card-header" id="heading-26">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-26" aria-expanded="false" aria-controls="collapse-26">
           <i class="fas fa-question-circle"></i> 土の入れ替えはどのように行えば良い？
      </h5>
    </div>
    <div id="collapse-26" class="collapse" aria-labelledby="heading-26" data-parent="#accordion-2">
      <div class="card-body">
        理想的な土作りは、赤土か黒土に腐葉土3割程度、有機肥料0.5割程度を混ぜ合わせた状態です。用意できる赤土や黒土の量が少ない場合は、掘り上げた土と混ぜてもだいぶ良くなります。肥料は、追肥でも十分効果的です。あまり土に混ぜ込みすぎると、肥料焼けをして枯れる場合もあります。
      </div>
    </div>
  </div>
  
  <div class="card mb-1">
    <div class="card-header" id="heading-27">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-27" aria-expanded="false" aria-controls="collapse-27">
           <i class="fas fa-question-circle"></i> 植木や下草が枯れない環境とは？
      </h5>
    </div>
    <div id="collapse-27" class="collapse" aria-labelledby="heading-27" data-parent="#accordion-2">
      <div class="card-body">
        植木や下草が枯れないためには、土壌も大切ですが、その他の環境もとても重要です。日向を好む木や日陰でしか耐えられない木、寒い地方では枯れてしまう植物、暖かい地方ではなかなか育たない植物など、特徴は様々です。個別ページを参考にするか、ご不明な点はぜひお問い合わせくださいませ。
      </div>
    </div>
  </div>
  
  <div class="card mb-1">
    <div class="card-header" id="heading-28">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-28" aria-expanded="false" aria-controls="collapse-28">
           <i class="fas fa-question-circle"></i> 植木が届く前に穴を掘って準備をしておきたいのですが、鉢の大きさは、どのくらいですか？
      </h5>
    </div>
    <div id="collapse-28" class="collapse" aria-labelledby="heading-28" data-parent="#accordion-2">
      <div class="card-body">
        植木によって変わりますが、大体直径45cm深さ40cmの穴を掘って頂ければおさまる大きさです。もちろん木によって変わりますので気になる方は事前にお問い合わせください。
      </div>
    </div>
  </div>
  
  <div class="card mb-1">
    <div class="card-header" id="heading-29">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-29" aria-expanded="false" aria-controls="collapse-29">
           <i class="fas fa-question-circle"></i> 植木を植えたい場所の下に水道管などの配管が。将来的に根が伸びた時の、木や配管への影響は？
      </h5>
    </div>
    <div id="collapse-29" class="collapse" aria-labelledby="heading-29" data-parent="#accordion-2">
      <div class="card-body">
        あまり影響はないと考えられます。根は配管を避けて伸びていきますし、配管は根で壊れる事はありません。ですが、街路樹の桜の根がアスファルトを持ち上げることもあるように、桜類だけはご注意いただければと思います。
      </div>
    </div>
  </div>
  
  <div class="card mb-1">
    <div class="card-header" id="heading-30">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-30" aria-expanded="false" aria-controls="collapse-30">
           <i class="fas fa-question-circle"></i> 下草の植え付けの間隔はどのくらい？
      </h5>
    </div>
    <div id="collapse-30" class="collapse" aria-labelledby="heading-30" data-parent="#accordion-2">
      <div class="card-body">
        9cmポットで平均して申し上げると、20cm間隔に植えるのが一般的です。1平米約25個です。
      </div>
    </div>
  </div>
  
  <div class="card mb-1">
    <div class="card-header" id="heading-31">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-31" aria-expanded="false" aria-controls="collapse-31">
           <i class="fas fa-question-circle"></i> 一日を通して日がほとんど当たらない場所ですが、植物を植えても大丈夫ですか？
      </h5>
    </div>
    <div id="collapse-31" class="collapse" aria-labelledby="heading-31" data-parent="#accordion-2">
      <div class="card-body">
        日当たりを好む植物の場合は、あまり望ましくありません。花の量が少なかったり枯れる恐れもあります。日陰でしか育たない植物もありますのでそちらをお勧めします。
      </div>
    </div>
  </div>
  
  <div class="card mb-1">
    <div class="card-header" id="heading-32">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-32" aria-expanded="false" aria-controls="collapse-32">
           <i class="fas fa-question-circle"></i> 雪と霜が心配なんだけど植えても大丈夫？
      </h5>
    </div>
    <div id="collapse-32" class="collapse" aria-labelledby="heading-32" data-parent="#accordion-2">
      <div class="card-body">
        植木などは冬場の植え付けでも問題ありません。積雪が深い場合は、なるべく雪が解けてからの方が作業がしやすいのでしょう。
下草などの草花を露地に植える場合は、霜で持ち上げられて痛む場合がありますので、なるべくあたたかくなってからの方がよいと思います。
      </div>
    </div>
  </div>
  
</div>
</section>


<section>
<h3>ご注文前の商品について</h3>

<div id="accordion-3">
  <div class="card">
    <div class="card-header" id="heading-33">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-17" aria-expanded="true" aria-controls="collapse-33">
          <i class="fas fa-question-circle"></i> 植木の植え付け適期は4月ではないのですか？
      </h5>
    </div>

    <div id="collapse-33" class="collapse" aria-labelledby="heading-33" data-parent="#accordion-3">
      <div class="card-body">
        植木の植え付け適期は、落葉樹は落葉後から芽吹き始める3月末くらいまで。常緑樹は、3月から6月の間です。それ以外の時期でも、根をきちんとつくっていますので植え付けは可能です。
      </div>
    </div>
  </div>
  
  <div class="card">
    <div class="card-header" id="heading-34">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-34" aria-expanded="false" aria-controls="collapse-34">
          <i class="fas fa-question-circle"></i> 下草などの植え付け適期はいつですか？
      </h5>
    </div>
    <div id="collapse-34" class="collapse" aria-labelledby="heading-34" data-parent="#accordion-3">
      <div class="card-body">
        積雪がある時期は避けた方がよろしいかと思います。それ以外の時期は、大丈夫です。一番良いのは春と秋です。
      </div>
    </div>
  </div>
  
  <div class="card">
    <div class="card-header" id="heading-35">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-35" aria-expanded="false" aria-controls="collapse-35">
           <i class="fas fa-question-circle"></i> なぜ落葉樹は落葉後が移植適期なのですか？
      </h5>
    </div>
    <div id="collapse-35" class="collapse" aria-labelledby="heading-35" data-parent="#accordion-3">
      <div class="card-body">
        木は根と葉のバランスで生命が成り立っています。落葉樹は葉が落ちると根もその役割が無い為、休眠状態に入ります。落葉後に根を切っておけば、良く春に芽吹く際、根の量に合わせて葉を芽吹かせることができるので、木への負担が少ないので一番の適期なのです。
      </div>
    </div>
  </div>
  
  <div class="card">
    <div class="card-header" id="heading-36">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-36" aria-expanded="false" aria-controls="collapse-36">
           <i class="fas fa-question-circle"></i> なぜ常緑樹は、3月から6月が適期なのですか？
      </h5>
    </div>
    <div id="collapse-36" class="collapse" aria-labelledby="heading-36" data-parent="#accordion-3">
      <div class="card-body">
        常緑樹は常に葉がありますので、冬でも根は動いています。春から梅雨の間は根が活発に動く事で、根つきが良くなります。ですが、理屈は落葉樹と同じですので、十分に根を移植に耐えるように根切りをして細かくしておくことが大切です。
      </div>
    </div>
  </div>
  
  <div class="card">
    <div class="card-header" id="heading-37">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-37" aria-expanded="false" aria-controls="collapse-37">
           <i class="fas fa-question-circle"></i> 写真で掲載している商品と全く同じものが届くのでしょうか？
      </h5>
    </div>
    <div id="collapse-37" class="collapse" aria-labelledby="heading-37" data-parent="#accordion-3">
      <div class="card-body">
        商品名の所に【現品発送】と記述のあるものは、写真の商品が届きます。それ以外のものは同品質で似たような姿の商品の配送となります。もし写真と同じようなものが良いとのご要望があれば、注文時の備考欄に「なるべく写真と同じような樹形のもの希望」などと記述いただければ、出来る限りご要望にお応えいたします。または、事前にご相談いただく事も可能です。
      </div>
    </div>
  </div>
  
  <div class="card">
    <div class="card-header" id="heading-38">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-38" aria-expanded="false" aria-controls="collapse-38">
           <i class="fas fa-question-circle"></i> 現品発送商品でも、状態が異なる事がありますか？
      </h5>
    </div>
    <div id="collapse-38" class="collapse" aria-labelledby="heading-38" data-parent="#accordion-3">
      <div class="card-body">
        落葉樹の場合は、冬は葉がついていなかったり、常緑樹で耐寒性のないものは冬葉を落としたりしています。また、移植の為に根を切る為、葉がしおれたり、葉が落ちたり、縮れたりする場合がありますが一時的なものですので品質に問題はありません。
      </div>
    </div>
  </div>
  
  <div class="card mb-1">
    <div class="card-header" id="heading-39">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-39" aria-expanded="false" aria-controls="collapse-39">
           <i class="fas fa-question-circle"></i> 初心者でも簡単に植え付けが出来ますか？
      </h5>
    </div>
    <div id="collapse-39" class="collapse" aria-labelledby="heading-39" data-parent="#accordion-3">
      <div class="card-body">
        こちらに掲載している手順で行っていただければ、初心者の方でも植え付けは可能です。本当に多くの方がチャレンジしています。<br>
        <a href="/howto-uetuke"><i class="fas fa-angle-double-right"></i> 植木の植え付け方</a>
        
      </div>
    </div>
  </div>
  
  <div class="card mb-1">
    <div class="card-header" id="heading-40">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-40" aria-expanded="false" aria-controls="collapse-40">
           <i class="fas fa-question-circle"></i> 植木や下草の管理は難しいですか？
      </h5>
    </div>
    <div id="collapse-40" class="collapse" aria-labelledby="heading-40" data-parent="#accordion-3">
      <div class="card-body">
        専門的知識はほとんど必要ありません。個別ごとの注意事項を守り、定植後1年間はまめな水やりと元気のない様子であれば、適度に油粕などの有機肥料を与えてあげれば枯れ死につながる事はほとんどありません。
      </div>
    </div>
  </div>
  
  <div class="card mb-1">
    <div class="card-header" id="heading-41">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-41" aria-expanded="false" aria-controls="collapse-41">
           <i class="fas fa-question-circle"></i> 大きくならない植木はありますか？
      </h5>
    </div>
    <div id="collapse-41" class="collapse" aria-labelledby="heading-41" data-parent="#accordion-3">
      <div class="card-body">
        基本木は必ず大きくなります。成長を止める事は出来ませんが、鉢植えにして成長の速度を遅くしたり、剪定によって高さや広がりを制限することが可能です。<br>
※鉢植えに向かない植木もありますので、ご相談ください。
      </div>
    </div>
  </div>
  
  <div class="card mb-1">
    <div class="card-header" id="heading-42">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-42" aria-expanded="false" aria-controls="collapse-42">
           <i class="fas fa-question-circle"></i> 販売している植木で、大きいものはどれくらいの重さ？ 一人で運べる？
      </h5>
    </div>
    <div id="collapse-42" class="collapse" aria-labelledby="heading-42" data-parent="#accordion-3">
      <div class="card-body">
        3m近い株立ちの樹形の植木は、成人男性一人で何とか運べる重さです。重さにして50～60kg程度。もし運べなさそうであれば、配送業者の方に植え付けの位置まで運んでもらってしまうのも手だと思います。
      </div>
    </div>
  </div>
  
  <div class="card mb-1">
    <div class="card-header" id="heading-43">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-43" aria-expanded="false" aria-controls="collapse-43">
           <i class="fas fa-question-circle"></i> 枯れたら保証はあるのですか？
      </h5>
    </div>
    <div id="collapse-43" class="collapse" aria-labelledby="heading-43" data-parent="#accordion-3">
      <div class="card-body">
        当社では、6か月以内に当社が枯れたと判断した商品であれば、基本代替品の配送、もしくは代替品が無い場合は返金の処置をさせていただいております。詳しくは<br>
        <a href="/about-ensure"><i class="fas fa-angle-double-right"></i>「枯れ保証について」</a><br>
        をご覧ください。
      </div>
    </div>
  </div>
  
  <div class="card mb-1">
    <div class="card-header" id="heading-44">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-44" aria-expanded="false" aria-controls="collapse-44">
           <i class="fas fa-question-circle"></i> 商品を購入した後も育て方について相談に乗ってくれるのでしょうか？
      </h5>
    </div>
    <div id="collapse-44" class="collapse" aria-labelledby="heading-44" data-parent="#accordion-3">
      <div class="card-body">
        もちろんです。木は植え付けた後がとても重要になります。ぜひお気軽にご相談くださいませ。
      </div>
    </div>
  </div>
  
  <div class="card mb-1">
    <div class="card-header" id="heading-45">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-45" aria-expanded="false" aria-controls="collapse-45">
           <i class="fas fa-question-circle"></i> 実際に現物を見て商品購入を決めたいのですが可能ですか？
      </h5>
    </div>
    <div id="collapse-45" class="collapse" aria-labelledby="heading-45" data-parent="#accordion-3">
      <div class="card-body">
        可能です。実際に見ていただくとより良さが伝わると思いますので大歓迎です。弊社の圃場は売店のようにはなっていない本当の植木畑ですので、スタッフの案内が必要です。事前に希望日時をご連絡いただきご予約を取って頂く必要があります。ご予約がないとご案内ができない場合がございます。<br><br>

当店営業時間　月～土8:00～17:00（日、祝日除く）<br>
電話番号：0299-53-0030<br>
メール：<a href="mailto:info@green-rocket.jp">info@green-rocket.jp</a>
      </div>
    </div>
  </div>
  
  <div class="card mb-1">
    <div class="card-header" id="heading-46">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-46" aria-expanded="false" aria-controls="collapse-46">
           <i class="fas fa-question-circle"></i> 未入荷商品の予約・入荷のお知らせについて
      </h5>
    </div>
    <div id="collapse-46" class="collapse" aria-labelledby="heading-46" data-parent="#accordion-3">
      <div class="card-body">
        一部の先行予約販売品を除いて、未入荷商品のご予約は承っておりません。
何卒ご了承下さい。
また、商品入荷時の個別のご連絡はお受けできませんので、
こちらの新着情報や当店のメールマガジンをチェックして下さい。<br><br>

メールマガジンの登録はこちら<br>
<a href="/register"><i class="fas fa-angle-double-right"></i> 会員登録ページ</a><br><br>
尚、ツイッターでは入荷情報を最速でキャッチすることができます。<br>
<a href="https://twitter.com/shop8463">https://twitter.com/shop8463</a><br><br>
販売中の商品に関しては、3ヶ月間のお取り置きを行っております。<br>
詳しくは次の項をご覧ください。
      </div>
    </div>
  </div>
  
  <div class="card mb-1">
    <div class="card-header" id="heading-47">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-47" aria-expanded="false" aria-controls="collapse-47">
           <i class="fas fa-question-circle"></i> 商品の取り置きは可能？
      </h5>
    </div>
    <div id="collapse-47" class="collapse" aria-labelledby="heading-47" data-parent="#accordion-3">
      <div class="card-body">
        弊社では3ヶ月間であれば商品を取り置かせていただいております。良い木を見つけたけど、植え込みは庭の工事が終わってからでないと・・という場合にご利用ください。尚、3ヶ月後に万が一キャンセルの場合は、決済がすでに済んでしまっている場合もありますので、その際、既に他社に支払った手数料などは返金にならない場合があります。ご注意ください。
      </div>
    </div>
  </div>
  
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






