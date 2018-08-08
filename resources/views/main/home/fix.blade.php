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
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-33" aria-expanded="true" aria-controls="collapse-33">
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


<section>
<h3>ご注文方法について</h3>

<div id="accordion-4">
  <div class="card">
    <div class="card-header" id="heading-48">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-48" aria-expanded="true" aria-controls="collapse-48">
          <i class="fas fa-question-circle"></i> 会員登録をしなくても購入できる？
      </h5>
    </div>

    <div id="collapse-48" class="collapse" aria-labelledby="heading-48" data-parent="#accordion-4">
      <div class="card-body">
        会員登録をしていただかなくとも購入することは可能です。
      </div>
    </div>
  </div>
  
  <div class="card">
    <div class="card-header" id="heading-49">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-49" aria-expanded="false" aria-controls="collapse-49">
          <i class="fas fa-question-circle"></i> 会員登録をするメリットは？
      </h5>
    </div>
    <div id="collapse-49" class="collapse" aria-labelledby="heading-49" data-parent="#accordion-4">
      <div class="card-body">
        2回目以降ご利用いただく際に、住所入力などの手間を省く事が出来ます。また、ポイント還元、入荷情報などのメールマガジン（希望者のみ）などがあります。
      </div>
    </div>
  </div>
  
  <div class="card">
    <div class="card-header" id="heading-50">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-50" aria-expanded="false" aria-controls="collapse-50">
           <i class="fas fa-question-circle"></i> 注文から商品受け取りまでの流れを教えて。
      </h5>
    </div>
    <div id="collapse-50" class="collapse" aria-labelledby="heading-50" data-parent="#accordion-4">
      <div class="card-body">
        ご注文いただきました後は、こちらからご注文内容を確認する自動返信のご注文確認メールが届きます。その後、こちらからご注文内容を確認し再度ご連絡差し上げる注文確定メールをお送りいたします。そこに配送日時を記載してお送りいたしますので、その予定に従い商品をお受け取りください。配送指定が無い場合は、最短でのお届けとなります。
      </div>
    </div>
  </div>
  
  <div class="card">
    <div class="card-header" id="heading-51">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-51" aria-expanded="false" aria-controls="collapse-51">
           <i class="fas fa-question-circle"></i> 注文確認メールが来ないのですが。ちゃんと注文出来ているんでしょうか？
      </h5>
    </div>
    <div id="collapse-51" class="collapse" aria-labelledby="heading-51" data-parent="#accordion-4">
      <div class="card-body">
        商品をご注文いただいたあとに必ずこちらより2通のメールをお送りします。1通目は、自動返信による注文内容確認メールです。2通目は店舗側で確かに注文を承りました、という注文確定メールとなります。2通目の注文確定メールは、遅くともご注文の当日か、翌営業日の午前中までには返信をしておりますので、その間に2通のメールが届かないようであれば、何らかの原因で注文が出来ていない可能性がありますので、大変お手数ですが一度ご一報いただければと存じます。また下記の原因も考えられますので、ご確認くださいますようお願いします。<br><br>

■フリーメールをご利用の場合
hotmail.com／hotmail.co.jp／yahoo.co.jp／goo.co.jpなど、
フリーメールをご利用の場合は、自動的にメールを受信規制すること
があり、一般のご使用に関しては問題ないアドレスでも、
受信できない事があります。当社からのメールが届かない場合には、
恐れ入りますが、一度、迷惑メールボックスをご確認下さい。
<br><br>
■お使いのメールソフトの設定による場合
ご使用のメールソフトやセキュリティソフトの設定により、
自動的にメールが削除されている場合がございます。
当店からのメールがゴミ箱や迷惑メールに入っていることもございま
すので、ご確認をお願いいたします。
      </div>
    </div>
  </div>
  
  <div class="card">
    <div class="card-header" id="heading-52">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-52" aria-expanded="false" aria-controls="collapse-52">
           <i class="fas fa-question-circle"></i> 1通目の自動返信の注文確認メールと、2通目の注文確定メールの違いって？
      </h5>
    </div>
    <div id="collapse-52" class="collapse" aria-labelledby="heading-52" data-parent="#accordion-4">
      <div class="card-body">
        お客様からご注文をいただきました後、クレジットカード使用可能の有無、配送料の確認などを行い、2通目の注文確定メールをお送りしております。同梱包商品や配送料変更の可能性のある商品は、このメールにてご請求金額を変更してご連絡しております。また、ご指定のカードが利用できない場合などのご連絡もこちらのメールで行いますので、必ずご確認をいただきますようお願いいたします。
      </div>
    </div>
  </div>
  
</div>
</section>


<section>
<h3>お支払いについて</h3>

<div id="accordion-5">
  <div class="card">
    <div class="card-header" id="heading-53">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-53" aria-expanded="true" aria-controls="collapse-53">
          <i class="fas fa-question-circle"></i> 支払い方法は？
      </h5>
    </div>

    <div id="collapse-53" class="collapse" aria-labelledby="heading-53" data-parent="#accordion-5">
      <div class="card-body">
        クレジットカード払い、代金引換（着払い）、銀行振り込み、コンビニ決済です。銀行振り込みとコンビニ決済の場合は、入金確認後の商品発送となります。
      </div>
    </div>
  </div>
  
  <div class="card">
    <div class="card-header" id="heading-54">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-54" aria-expanded="false" aria-controls="collapse-54">
          <i class="fas fa-question-circle"></i> 領収書の発行は？
      </h5>
    </div>
    <div id="collapse-54" class="collapse" aria-labelledby="heading-54" data-parent="#accordion-5">
      <div class="card-body">
        はい可能です。商品注文の際に、備考欄に領収書希望の旨と宛名を書いていただければご対応させていただきます。
      </div>
    </div>
  </div>
  
  <div class="card">
    <div class="card-header" id="heading-55">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-55" aria-expanded="false" aria-controls="collapse-55">
           <i class="fas fa-question-circle"></i> 請求書の発行はできますか？
      </h5>
    </div>
    <div id="collapse-55" class="collapse" aria-labelledby="heading-55" data-parent="#accordion-5">
      <div class="card-body">
        はい可能です。商品注文の際に、備考欄に請求書希望の旨と宛名を書いていただければご対応させていただきます。
      </div>
    </div>
  </div>
  
  <div class="card">
    <div class="card-header" id="heading-56">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-56" aria-expanded="false" aria-controls="collapse-56">
           <i class="fas fa-question-circle"></i> クレジットカードの控えは、商品に同封されますか？
      </h5>
    </div>
    <div id="collapse-56" class="collapse" aria-labelledby="heading-56" data-parent="#accordion-5">
      <div class="card-body">
        いいえ、当社ではクレジットカードは電子決済となりますので同封されません。
      </div>
    </div>
  </div>
  
  <div class="card">
    <div class="card-header" id="heading-57">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-57" aria-expanded="false" aria-controls="collapse-57">
           <i class="fas fa-question-circle"></i> 明細書は付いてくる？
      </h5>
    </div>
    <div id="collapse-57" class="collapse" aria-labelledby="heading-57" data-parent="#accordion-5">
      <div class="card-body">
        いいえ、ついていません。事前にお送りするメールにて完結させていただいております。別途明細書が必要な方は、商品注文の際に、備考欄に明細書希望の旨の記述をお願いいたします。
      </div>
    </div>
  </div>
  
</div>
</section>


<section>
<h3>配送前の商品について</h3>

<div id="accordion-6">
  <div class="card">
    <div class="card-header" id="heading-58">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-58" aria-expanded="true" aria-controls="collapse-58">
          <i class="fas fa-question-circle"></i> お届け日、お届け時間の指定はできますか？
      </h5>
    </div>

    <div id="collapse-58" class="collapse" aria-labelledby="heading-58" data-parent="#accordion-6">
      <div class="card-body">
        はい可能です。日にち、時間ともに配送業者の指定する時間帯において指定できます。ですが地域によっては「午前中」や「13時前後」の指定が出来ない場合があります。事前にお問い合わせくださいませ。
      </div>
    </div>
  </div>
  
  <div class="card">
    <div class="card-header" id="heading-59">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-59" aria-expanded="false" aria-controls="collapse-59">
          <i class="fas fa-question-circle"></i> 午前中配送不可エリアについて
      </h5>
    </div>
    <div id="collapse-59" class="collapse" aria-labelledby="heading-59" data-parent="#accordion-6">
      <div class="card-body">
        佐川急便さん、西濃運輸さんの配送エリアには午前中配送ができないエリアがございます。<br>
こちらのエリアは午後便のみとなり、佐川急便さんは16時～18時より、西濃運輸は13時～17時のお届けとなります。<br>
ご不便をおかけしますが予めご了承下さい。
      </div>
    </div>
  </div>
  
  <div class="card">
    <div class="card-header" id="heading-60">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-60" aria-expanded="false" aria-controls="collapse-60">
           <i class="fas fa-question-circle"></i> 配送日時の変更は可能ですか？
      </h5>
    </div>
    <div id="collapse-60" class="collapse" aria-labelledby="heading-60" data-parent="#accordion-6">
      <div class="card-body">
        商品配送前であれば可能です。商品配送はお届け指定日の大体2日前に出荷いたします。出荷日の当日12時までに変更のご連絡をお願いいたします。
      </div>
    </div>
  </div>
  
  <div class="card">
    <div class="card-header" id="heading-61">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-61" aria-expanded="false" aria-controls="collapse-61">
           <i class="fas fa-question-circle"></i> 配送のタイミングを教えてください。
      </h5>
    </div>
    <div id="collapse-61" class="collapse" aria-labelledby="heading-61" data-parent="#accordion-6">
      <div class="card-body">
        お届け指定日のある商品は、指定日の大体2日前。お届け指定日の無いものは最短の発送となり、当日昼12時までのご注文で当日発送、それ以降にご注文いただきました商品は翌日発送となります。
      </div>
    </div>
  </div>
  
  <div class="card">
    <div class="card-header" id="heading-62">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-62" aria-expanded="false" aria-controls="collapse-62">
           <i class="fas fa-question-circle"></i> 商品は最短でどのくらいで届きますか？
      </h5>
    </div>
    <div id="collapse-62" class="collapse" aria-labelledby="heading-62" data-parent="#accordion-6">
      <div class="card-body">
        当日昼の12時までにご注文いただいたものは、その日の出荷でお送りいたします。関東周辺は翌日。北東北以北、関西以西は大体2日後の到着となります。
      </div>
    </div>
  </div>
  
  <div class="card">
    <div class="card-header" id="heading-63">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-63" aria-expanded="false" aria-controls="collapse-63">
           <i class="fas fa-question-circle"></i> 送料はどのくらいかかりますか？
      </h5>
    </div>
    <div id="collapse-63" class="collapse" aria-labelledby="heading-63" data-parent="#accordion-6">
      <div class="card-body">
      	--- 品物と地域商品により異なります。
      </div>
    </div>
  </div>
  
  <div class="card mb-1">
    <div class="card-header" id="heading-64">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-64" aria-expanded="false" aria-controls="collapse-64">
           <i class="fas fa-question-circle"></i> 植木の同梱包は可能ですか？
      </h5>
    </div>
    <div id="collapse-64" class="collapse" aria-labelledby="heading-64" data-parent="#accordion-6">
      <div class="card-body">
        --- 可能です。下草、コニファー、果樹などは同梱包が可能です。既定のサイズの配送箱に収まれば、同一の配送料となりある意味つめ放題です！
        
      </div>
    </div>
  </div>
  
  <div class="card mb-1">
    <div class="card-header" id="heading-65">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-65" aria-expanded="false" aria-controls="collapse-65">
           <i class="fas fa-question-circle"></i> お届け予定日に急用で荷物が受け取れない場合はどうしたらいいですか？
      </h5>
    </div>
    <div id="collapse-65" class="collapse" aria-labelledby="heading-65" data-parent="#accordion-6">
      <div class="card-body">
        ご不在時には、配達ドライバーが「ご不在時連絡票」をポストなどに投函しますので、そちらに記載されているお近くの運送会社営業所へご連絡をお願いします。万一、保管期間（2日間）を超えてお荷物をお引取りいただいていない場合、お荷物は一旦当店に引き上げとなります。その際に掛かった送料、及び再送させていただく際の往復の送料を申し受ける可能性がございますので、予めご了承下さい。また、2日程度の保管期間を経て受取・植栽をした後、樹木の品質に問題が生じたとしても保証の対象となりませんのでご注意くださいませ。
      </div>
    </div>
  </div>
  
</div>
</section>


<section>
<h3>ギフトについて</h3>

<div id="accordion-7">
  <div class="card">
    <div class="card-header" id="heading-66">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-66" aria-expanded="true" aria-controls="collapse-66">
          <i class="fas fa-question-circle"></i> ギフトで送る際、明細書は？
      </h5>
    </div>

    <div id="collapse-66" class="collapse" aria-labelledby="heading-66" data-parent="#accordion-7">
      <div class="card-body">
        当社では明細書は事前のメールにて完結させていただいておりますので、商品に明細書は付いてきません。ご安心ください。
      </div>
    </div>
  </div>
  
  <div class="card">
    <div class="card-header" id="heading-67">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-67" aria-expanded="false" aria-controls="collapse-67">
          <i class="fas fa-question-circle"></i> ギフト配送時の宛名は？
      </h5>
    </div>
    <div id="collapse-67" class="collapse" aria-labelledby="heading-67" data-parent="#accordion-7">
      <div class="card-body">
        ご注文者様のお名前と配送先のお宛名が違う場合、注文者様のお名前を宛名に記載してお送りしますので、受け取った方がどなたから送られてきたものかわかるようにしております。
      </div>
    </div>
  </div>
  
  <div class="card">
    <div class="card-header" id="heading-68">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-68" aria-expanded="false" aria-controls="collapse-68">
           <i class="fas fa-question-circle"></i> メッセージを添えてほしいんだけど。
      </h5>
    </div>
    <div id="collapse-68" class="collapse" aria-labelledby="heading-68" data-parent="#accordion-7">
      <div class="card-body">
        はい可能です。無料で対応させていただいております。ご注文の際に、備考欄にメッセージを望む旨と、メッセージ内容をお書き頂ければ、簡単なメッセージカードに手書きのメッセージを添えさせていただきます。
      </div>
    </div>
  </div>
  
  <div class="card">
    <div class="card-header" id="heading-69">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-69" aria-expanded="false" aria-controls="collapse-69">
           <i class="fas fa-question-circle"></i> ラッピングは出来る？
      </h5>
    </div>
    <div id="collapse-69" class="collapse" aria-labelledby="heading-69" data-parent="#accordion-7">
      <div class="card-body">
        商品が商品なだけに、ラッピングは行っておりませんが、簡単なリボン程度であれば装飾が可能です。無料で承っております。ご注文の際に、備考欄にリボン希望の旨をお書き添えください。
      </div>
    </div>
  </div>
  
</div>
</section>


<section>
<h3>届いた商品の状態について</h3>

<div id="accordion-8">
  <div class="card">
    <div class="card-header" id="heading-70">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-70" aria-expanded="true" aria-controls="collapse-70">
          <i class="fas fa-question-circle"></i> 植木が届いたのですが、植え付けがその日に出来ない場合はどのようにしたらいいですか？
      </h5>
    </div>

    <div id="collapse-70" class="collapse" aria-labelledby="heading-70" data-parent="#accordion-8">
      <div class="card-body">
        1～2日程度であれば、梱包をといて鉢の部分にたっぷりと水をかけ、必ず日陰に保管していただければ大丈夫です。その際横に倒したままでも大丈夫です。
      </div>
    </div>
  </div>
  
  <div class="card">
    <div class="card-header" id="heading-71">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-71" aria-expanded="false" aria-controls="collapse-71">
          <i class="fas fa-question-circle"></i> 植木の場合、届いてからどのくらい植えなくても大丈夫ですか？
      </h5>
    </div>
    <div id="collapse-71" class="collapse" aria-labelledby="heading-71" data-parent="#accordion-8">
      <div class="card-body">
        なるべくすぐに植え付けをしてください。<br>
とくに真夏は丸1日日なたに置いておくと木が傷んで最悪枯れる場合もあります。
<br><br>
万が一植え付けが出来ない場合は、梱包をといて日陰の場所に穴を掘って仮植えをしてください。
その際たっぷりと水をかけるようにしてください。
<br><br>
落葉樹は、落葉後から芽吹くまでの12月中旬から3月半ばまでの間は、仮死状態になっていますので、その期間内に植え付けをすればすこし放っておいても大丈夫ですが、なるべく到着から2週間以内に植え付けて頂けますようお願いします。
<br><br>
尚、常緑樹は到着後すぐ、最悪でも2日以内には植え付けをお願いいたします。
      </div>
    </div>
  </div>
  
  <div class="card">
    <div class="card-header" id="heading-72">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-72" aria-expanded="false" aria-controls="collapse-72">
           <i class="fas fa-question-circle"></i> 届いてからすぐ植えない場合、梱包はとったほうがいいの？
      </h5>
    </div>
    <div id="collapse-72" class="collapse" aria-labelledby="heading-72" data-parent="#accordion-8">
      <div class="card-body">
        梱包は全て取って保管します。<br>
その際、根巻きの場合は、麻布を取らないようにします。<br>
地中ポットの場合は、植え付けの直前にポットをはがすようにします。<br><br>

保管方法はこちらを確認してください。<br>
<a href="">---</a>
      </div>
    </div>
  </div>
  
  <div class="card">
    <div class="card-header" id="heading-73">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-73" aria-expanded="false" aria-controls="collapse-73">
           <i class="fas fa-question-circle"></i> ポットと根巻きの違いは？
      </h5>
    </div>
    <div id="collapse-73" class="collapse" aria-labelledby="heading-73" data-parent="#accordion-8">
      <div class="card-body">
        ポットとは、不織布地中ポットの事で、植え付け前に切ってはがし根がむき出しの状態にして植え付ける必要があります。写真では根元が黒い筒状のものがそれに当たります。<br>

根巻きとは、根元が麻布で巻かれているもので、剥がさずそのまま植える事ができます。
麻布と麻ひもは3カ月～半年程度で腐って地中に還ります。<br>

ポットと根巻きの植え付け方法はこちらをご覧ください。<br><br>

<a href="/howto-uetuke"><i class="fas fa-angle-double-right"></i> 植栽方法</a>
      </div>
    </div>
  </div>
  
  <div class="card">
    <div class="card-header" id="heading-74">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-74" aria-expanded="false" aria-controls="collapse-74">
           <i class="fas fa-question-circle"></i> 下草の場合、届いてから植え付けまでどのような管理が必要ですか？
      </h5>
    </div>
    <div id="collapse-74" class="collapse" aria-labelledby="heading-74" data-parent="#accordion-8">
      <div class="card-body">
        下草が届いてから植え付けるまで時間がある場合、毎日適量の水やりを行って管理をしてください。出来れば日陰で保管した方が状態が良いです。ですが、やはりなるべく早く植えていただきたいと思います。
      </div>
    </div>
  </div>
  
  <div class="card">
    <div class="card-header" id="heading-75">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-75" aria-expanded="false" aria-controls="collapse-75">
           <i class="fas fa-question-circle"></i> 下草を購入したが、写真で載っているものより商品が小さかった。
      </h5>
    </div>
    <div id="collapse-75" class="collapse" aria-labelledby="heading-75" data-parent="#accordion-8">
      <div class="card-body">
        下草は、1年でその大きさがかなり変化するため、時期によって苗の大きさが変わります。写真で掲載しているものはなるべく小さな時のものを映すようにしていますが、やはり誤差が出る場合があります。その年に同じ大きさになる同品質のものをお送りしておりますので、何卒ご了承いただければと思います。
      </div>
    </div>
  </div>
  
  <div class="card mb-1">
    <div class="card-header" id="heading-76">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-76" aria-expanded="false" aria-controls="collapse-76">
           <i class="fas fa-question-circle"></i> 常緑の植木を注文したのに、葉が落ちていたり葉の色が悪くなっていた。
      </h5>
    </div>
    <div id="collapse-76" class="collapse" aria-labelledby="heading-76" data-parent="#accordion-8">
      <div class="card-body">
        南方系が原産のシマトネリコやオリーブ、フェイジョア、常緑ヤマボウシなどは冬の寒さで葉色が悪くなったり葉をほとんど落とす場合もあります。その状態は、11月から春の芽吹きが終わる6月頃まで続きます。南方原産の為そのような事が起こります事をご了承いただければと思います。
        
      </div>
    </div>
  </div>
  
  <div class="card mb-1">
    <div class="card-header" id="heading-77">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-77" aria-expanded="false" aria-controls="collapse-77">
           <i class="fas fa-question-circle"></i> 常緑樹を購入したのですが、葉に白い薬剤のようなものがかかっているのですが。
      </h5>
    </div>
    <div id="collapse-77" class="collapse" aria-labelledby="heading-77" data-parent="#accordion-8">
      <div class="card-body">
        それは石灰硫黄合剤という薬剤で、年に1度2月頃に植木に散布する薬剤です。非常に効果的な薬剤で、1年間木に虫や病気が付きにくくするためのものですので洗い流さないようにお願いいたします。6月頃には雨で流れて落ちますので、しばらくそのままにしておくようにして下さい。
      </div>
    </div>
  </div>
  
  <div class="card mb-1">
    <div class="card-header" id="heading-78">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-78" aria-expanded="false" aria-controls="collapse-78">
           <i class="fas fa-question-circle"></i> 葉に黒い斑点がたくさん出ているのですが、これは病気ですか？
      </h5>
    </div>
    <div id="collapse-78" class="collapse" aria-labelledby="heading-78" data-parent="#accordion-8">
      <div class="card-body">
        黒斑点病という病気で、掘り上げる際に根を切ったりすると稀に出ます。主にソヨゴ、ハイノキ、アオダモ等に見られます。これは病気ではありますが、枯れ死にいたる事はほとんどなく、他に感染しないため品質には問題は無いと当社では考えています。そのため保証の対象とはなりません。
      </div>
    </div>
  </div>
  
  <div class="card mb-1">
    <div class="card-header" id="heading-79">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-79" aria-expanded="false" aria-controls="collapse-79">
           <i class="fas fa-question-circle"></i> 届いた木の葉のふち（や全体的に）しおれているのですが、大丈夫ですか？
      </h5>
    </div>
    <div id="collapse-79" class="collapse" aria-labelledby="heading-79" data-parent="#accordion-8">
      <div class="card-body">
        植木の場合春から秋にかけて多いのですが、根は地中にある涼しい状態から掘り上げられ、輸送中に鉢が暖まり機能を低下させています。そのため、うまく水分を吸い上げられず、葉がしおれます。早急に植え込みを行い、その後は、毎日1日一度たっぷり水やりを行います。それでも葉の調子が悪い場合には、まずは根を回復させるため、葉を半分から全部むしるようにしてください。これで大分状態が良くなります。それでも状況が悪化し枯れるようであれば、枯れ保証としてご対応させていただきます。下草などは、たっぷりと水をかけると徐々に回復していきます。
      </div>
    </div>
  </div>
  
  <div class="card mb-1">
    <div class="card-header" id="heading-80">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-80" aria-expanded="false" aria-controls="collapse-80">
           <i class="fas fa-question-circle"></i> 下草を注文したら、一部葉が枯れているのが届いた。
      </h5>
    </div>
    <div id="collapse-80" class="collapse" aria-labelledby="heading-80" data-parent="#accordion-8">
      <div class="card-body">
        茨城県で生産しております。冬になると一部葉を落としたり、花が終わった後に疲れで葉が少し枯れるものもありますが、品質には問題が無い為、そのままお送りさせていただいています。ポット内での限られた養分の為そのような状態が起こりますが、定植後は十分に栄養を得ることができる為、そのような状態が改善されていきます。
      </div>
    </div>
  </div>
  
  <div class="card mb-1">
    <div class="card-header" id="heading-81">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-81" aria-expanded="false" aria-controls="collapse-81">
           <i class="fas fa-question-circle"></i> 下草を注文したら、ポットだけが入っていた。または枯れた草が届いた。
      </h5>
    </div>
    <div id="collapse-81" class="collapse" aria-labelledby="heading-81" data-parent="#accordion-8">
      <div class="card-body">
        冬に一度枯れて春に芽吹く商品（ヘメロカリス等の宿根草）をご注文いただきました場合、時期によってはそのような状態で届きますが、根は生きており春に必ず芽吹きます。丁寧に植え付けを行っていただければと思います。
      </div>
    </div>
  </div>
  
  <div class="card mb-1">
    <div class="card-header" id="heading-82">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-82" aria-expanded="false" aria-controls="collapse-82">
           <i class="fas fa-question-circle"></i> 届いた商品の幹が真ん中から折れていた。
      </h5>
    </div>
    <div id="collapse-82" class="collapse" aria-labelledby="heading-82" data-parent="#accordion-8">
      <div class="card-body">
        配送中の事故だと思われますので、弊社にご連絡下さい。<br><br>

当店営業時間　月～土8:00～17:00（日、祝日除く）<br>
電話番号：0299-53-0030<br>
メール：<a href="mailto:info@green-rocket.jp">info@green-rocket.jp</a>
      </div>
    </div>
  </div>
  
  <div class="card mb-1">
    <div class="card-header" id="heading-83">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-83" aria-expanded="false" aria-controls="collapse-83">
           <i class="fas fa-question-circle"></i> 届いた商品の細い枝や下草の茎の一部が折れていた。
      </h5>
    </div>
    <div id="collapse-83" class="collapse" aria-labelledby="heading-83" data-parent="#accordion-8">
      <div class="card-body">
        生き物につき、多少の枝折れや損傷はご容赦いただければと思います。重大な枝折れが出ないような梱包をした上で配送しております。
      </div>
    </div>
  </div>
  
  <div class="card mb-1">
    <div class="card-header" id="heading-84">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-84" aria-expanded="false" aria-controls="collapse-84">
           <i class="fas fa-question-circle"></i> 下草を購入したが段ボールの中でポットが倒れていて苗が傷んでいた。
      </h5>
    </div>
    <div id="collapse-84" class="collapse" aria-labelledby="heading-84" data-parent="#accordion-8">
      <div class="card-body">
        破損状況を確認し、すぐに運送業者さんにご連絡してください。保証の対象となります。また、同時に弊社へのご連絡もお願いいたします。
      </div>
    </div>
  </div>
  
  <div class="card mb-1">
    <div class="card-header" id="heading-85">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-85" aria-expanded="false" aria-controls="collapse-85">
           <i class="fas fa-question-circle"></i> 樹形や花が思っていたのと違ったから返品・交換したい。
      </h5>
    </div>
    <div id="collapse-85" class="collapse" aria-labelledby="heading-85" data-parent="#accordion-8">
      <div class="card-body">
        商品発送後のお客様個人の理由による商品の返品は基本受け付けておりません。大変訳ございません。幾分、生き物である為ご返品の際に輸送で商品が傷み、商品として再度販売できないためです。もし心配であれば樹形の詳細をお問い合わせ下さい。どうしても返品をご希望のお客様は、弊社にご連絡後、商品を着払いにて返送をお願いいたします。その際、配送業者に支払う配送料、消費税、カード会社などの手数料、返送送料は返金の対象となりません。お支払いいただいた金額から、上記と返品手数料として木代金の1割を差し引いてのご返金となりますのでご了承ください。また、交換の場合は、返送料金と交換商品の配送料金+木代金の1割を手数料として追加でご請求となります事をご了承ください。
      </div>
    </div>
  </div>
  
  <div class="card mb-1">
    <div class="card-header" id="heading-86">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-86" aria-expanded="false" aria-controls="collapse-86">
           <i class="fas fa-question-circle"></i> 届いた商品の葉の一部が縮れていて若葉もあまり出ていず少し葉が落ちていた。現品発送なのに写真と同じでない状態で正規の金額を請求するのはけしからん。
      </h5>
    </div>
    <div id="collapse-86" class="collapse" aria-labelledby="heading-86" data-parent="#accordion-8">
      <div class="card-body">
        植物は工業製品ではありませんので、掘って輸送する間に痛みが出てしまうことがあります。商品の特性上、その時の状態が価値を決めるのではなく2年後や将来にわたってお楽しみいただくものであると考えていますので、品質に問題が無く、傷んだ状態から写真を撮ったとき状態に回復すると見込まれるものは、保証の対象となりません。ご了承ください。もちろんその後、状況が良くならず枯れ死に及んだ場合は、保証の対象とさせていただきます。
      </div>
    </div>
  </div>
  
  <div class="card mb-1">
    <div class="card-header" id="heading-87">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-87" aria-expanded="false" aria-controls="collapse-87">
           <i class="fas fa-question-circle"></i> 花を楽しみに買ったのに、花が楽しめなかった。
      </h5>
    </div>
    <div id="collapse-87" class="collapse" aria-labelledby="heading-87" data-parent="#accordion-8">
      <div class="card-body">
        商品ページに「花芽つき」「実つき」と記載のあるものを除き、花芽や果実の有無を特定して販売をしておりません。花芽、果実の有無多少は時期と個体差があります。また輸送中で落ちてしまう場合もあります。花は来年、再来年とずっと先まで楽しめます。ぜひ来年の楽しみとしていただき、それまで可愛がっていただければと思います。
      </div>
    </div>
  </div>
  
  <div class="card mb-1">
    <div class="card-header" id="heading-88">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-88" aria-expanded="false" aria-controls="collapse-88">
           <i class="fas fa-question-circle"></i> 植木を植えつけたらみるみる内に葉が落ちた。これは枯れたのではないですか？
      </h5>
    </div>
    <div id="collapse-88" class="collapse" aria-labelledby="heading-88" data-parent="#accordion-8">
      <div class="card-body">
        植物は環境が変わると、その環境に慣れる為に、自ら葉を落として根と葉のバランスを調整します。ですので枯れたのではありません。しばらく様子を見ていただき、更に具合が悪くなるようであれば、ご一報ください。
      </div>
    </div>
  </div>
  
</div>
</section>


<section>
<h3>返品・交換・キャンセル・保証について</h3>

<div id="accordion-9">
  <div class="card">
    <div class="card-header" id="heading-89">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-89" aria-expanded="true" aria-controls="collapse-89">
          <i class="fas fa-question-circle"></i> 商品のキャンセルは出来ますか？
      </h5>
    </div>

    <div id="collapse-89" class="collapse" aria-labelledby="heading-89" data-parent="#accordion-9">
      <div class="card-body">
        発送前の商品であればキャンセルは可能です。発送のタイミングはこちらをご覧ください。<br>
        <a href="">---</a>
      </div>
    </div>
  </div>
  
  <div class="card">
    <div class="card-header" id="heading-90">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-90" aria-expanded="false" aria-controls="collapse-90">
          <i class="fas fa-question-circle"></i> 商品到着後にキャンセルは可能ですか？
      </h5>
    </div>
    <div id="collapse-90" class="collapse" aria-labelledby="heading-90" data-parent="#accordion-9">
      <div class="card-body">
        こちら側の不手際で届いた商品が間違っていたりする場合は、もちろんキャンセルが可能です。早急にご一報くださいませ。
      </div>
    </div>
  </div>
  
  <div class="card">
    <div class="card-header" id="heading-91">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-91" aria-expanded="false" aria-controls="collapse-91">
           <i class="fas fa-question-circle"></i> 訳あって商品到着から2日たってから開封したら思っていた商品と違った。
      </h5>
    </div>
    <div id="collapse-91" class="collapse" aria-labelledby="heading-91" data-parent="#accordion-9">
      <div class="card-body">
        お届け後2日経過してからのご返品や交換はお受けできません。商品は生き物ですので地面から離れている間、どんどん弱ってしまいます。荷物が到着しましたら、一旦箱の中をご確認ください。もし、お届けした商品に不備がありましたら、お急ぎ当店までご連絡をお願い致します。
      </div>
    </div>
  </div>
  
  <div class="card">
    <div class="card-header" id="heading-92">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-92" aria-expanded="false" aria-controls="collapse-92">
           <i class="fas fa-question-circle"></i> 樹形や花が思っていたのと違ったから返品・交換したい。
      </h5>
    </div>
    <div id="collapse-92" class="collapse" aria-labelledby="heading-92" data-parent="#accordion-9">
      <div class="card-body">
        商品お受け取り後の、樹形のイメージの相違や花芽の有無等を理由とした返品は受け付けておりません。何卒ご了承ください。
      </div>
    </div>
  </div>
  
  <div class="card">
    <div class="card-header" id="heading-93">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-93" aria-expanded="false" aria-controls="collapse-93">
           <i class="fas fa-question-circle"></i> 届いた商品の幹が真ん中から折れていた。
      </h5>
    </div>
    <div id="collapse-93" class="collapse" aria-labelledby="heading-93" data-parent="#accordion-9">
      <div class="card-body">
        配送中の事故だと思われますので、弊社にご連絡下さい。<br><br>

当店営業時間　月～土8:00～17:00（日、祝日除く）<br>
電話番号：0299-53-0030<br>
メール：<a href="mailto:info@green-rocket.jp">info@green-rocket.jp</a>
      </div>
    </div>
  </div>
  
  <div class="card">
    <div class="card-header" id="heading-95">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-95" aria-expanded="false" aria-controls="collapse-95">
           <i class="fas fa-question-circle"></i> 届いた商品の細い枝や下草の茎の一部が折れていた。
      </h5>
    </div>
    <div id="collapse-95" class="collapse" aria-labelledby="heading-95" data-parent="#accordion-9">
      <div class="card-body">
        生き物につき、多少の枝折れや損傷はご容赦いただければと思います。重大な枝折れが出ないように梱包し配送しております。
      </div>
    </div>
  </div>
  
  <div class="card mb-1">
    <div class="card-header" id="heading-96">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-96" aria-expanded="false" aria-controls="collapse-96">
           <i class="fas fa-question-circle"></i> 下草を購入したが段ボールの中でポットが倒れていて苗が傷んでいた。
      </h5>
    </div>
    <div id="collapse-96" class="collapse" aria-labelledby="heading-96" data-parent="#accordion-9">
      <div class="card-body">
        破損状況を確認し、すぐに運送業者さんにご連絡してください。保証の対象となります。また、同時に弊社へのご連絡もお願いいたします。
        
      </div>
    </div>
  </div>
  
  <div class="card mb-1">
    <div class="card-header" id="heading-97">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-97" aria-expanded="false" aria-controls="collapse-97">
           <i class="fas fa-question-circle"></i> 届いた商品の葉の一部が縮れていて若葉もあまり出ていず少し葉が落ちていた。現品発送なのに写真と同じでない状態で正規の金額を請求するのはけしからん。
      </h5>
    </div>
    <div id="collapse-97" class="collapse" aria-labelledby="heading-97" data-parent="#accordion-9">
      <div class="card-body">
        植物は工業製品ではありませんので、掘って輸送する間に痛みが出てしまうことがあります。商品の特性上、その時の状態が価値を決めるのではなく2年後や将来にわたってお楽しみいただくものであると考えていますので、品質に問題が無く、傷んだ状態から写真を撮ったとき状態に早期に回復すると見込まれるものは、保証の対象となりません。ご了承ください。もちろんその後、状況が良くならず枯れ死に及んだ場合は、保証の対象とさせていただきます。
      </div>
    </div>
  </div>
  
  <div class="card mb-1">
    <div class="card-header" id="heading-98">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-98" aria-expanded="false" aria-controls="collapse-98">
           <i class="fas fa-question-circle"></i> 枯れ保証について教えて下さい。
      </h5>
    </div>
    <div id="collapse-98" class="collapse" aria-labelledby="heading-98" data-parent="#accordion-9">
      <div class="card-body">
        当社では、当社からお送りした木が6カ月以内に当社が枯れたと判断した場合、代替え品の配送もしくは返金をさせていただいております。詳しくは、こちらをご覧ください。<br><br>
        <a href="/about-ensure"><i class="fas fa-angle-double-right"></i> 枯れ保証について</a>
      </div>
    </div>
  </div>
  
  <div class="card mb-1">
    <div class="card-header" id="heading-99">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-99" aria-expanded="false" aria-controls="collapse-99">
           <i class="fas fa-question-circle"></i> 花を楽しみに買ったのに、花が楽しめなかった。
      </h5>
    </div>
    <div id="collapse-99" class="collapse" aria-labelledby="heading-99" data-parent="#accordion-9">
      <div class="card-body">
        商品ページに「花芽つき」「実つき」と記載のあるものを除き、花芽や果実の有無を保証して販売をしておりません。花芽、果実の有無多少は時期と個体差があります。また輸送中で落ちてしまう場合もあります。花は来年、再来年とずっと先まで楽しめます。ぜひ来年の楽しみとしていただき、それまで可愛がっていただければと思います。
      </div>
    </div>
  </div>
  
  <div class="card mb-1">
    <div class="card-header" id="heading-100">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-100" aria-expanded="false" aria-controls="collapse-100">
           <i class="fas fa-question-circle"></i> 長期不在で荷物を受取れなかったため、傷んだ植物を処分した。
      </h5>
    </div>
    <div id="collapse-100" class="collapse" aria-labelledby="heading-100" data-parent="#accordion-9">
      <div class="card-body">
        長期のご不在が原因で商品を処分したり、商品に傷み・花枯れ等が生じた場合には返品・返金処理を承れません。お届け先様がご不在で商品のお届けができなかった場合、配達員が不在票を投函した後、お届け先様のご連絡に従いお届け致します。到着予定日を含め2日経過してもお届け先様よりご連絡がない場合、やむを得ず商品を処分させて頂く場合がございます。商品の処分後、再度配達をご希望の場合は、改めてご注文を頂く事になります。
      </div>
    </div>
  </div>
  
  <div class="card mb-1">
    <div class="card-header" id="heading-101">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-101" aria-expanded="false" aria-controls="collapse-101">
           <i class="fas fa-question-circle"></i> 代金引き換えで商品を注文し届いたが、キャンセルしたい。
      </h5>
    </div>
    <div id="collapse-101" class="collapse" aria-labelledby="heading-101" data-parent="#accordion-9">
      <div class="card-body">
        代金引換ご利用のお客様で、商品受け取りの際にお客様のご都合による受け取りの拒否（長期不在でのお届け不良も含む）などが当店へ連絡なく行われた場合、その際に発生した往復の送料・手数料・梱包資材・商品代金などをご請求させていただきますので十分にご注意くださいませ。
      </div>
    </div>
  </div>
  
  <div class="card mb-1">
    <div class="card-header" id="heading-102">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-102" aria-expanded="false" aria-controls="collapse-102">
           <i class="fas fa-question-circle"></i> クレジットカード決済で注文して、キャンセルした際返金はどのように行われますか。
      </h5>
    </div>
    <div id="collapse-102" class="collapse" aria-labelledby="heading-102" data-parent="#accordion-9">
      <div class="card-body">
        クレジットカードで決済注文して、キャンセルした場合、早急にクレジットカード会社への支払い請求を取り消します。しかし、ご注文からキャンセルまでに月をまたいでしまうと、カード決済の取り消しができません。（例：1月20日にご注文、2月7日にキャンセル）その際は弊社よりお客様のご指定口座へのご返金という形をとらせていただきますが、クレジットカード会社へ支払う手数料はすでに発生してしまいますのでその分を差し引いてのご返金となります。ご注文キャンセルの場合はすぐにご連絡いただきますようお願いいたします。
      </div>
    </div>
  </div>
  
  <div class="card mb-1">
    <div class="card-header" id="heading-103">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-103" aria-expanded="false" aria-controls="collapse-103">
           <i class="fas fa-question-circle"></i> 返金はどのように行われますか？
      </h5>
    </div>
    <div id="collapse-103" class="collapse" aria-labelledby="heading-103" data-parent="#accordion-9">
      <div class="card-body">
        枯れ保証やこちらの不手際で返金を行う場合、銀行振り込みにて代金を全額弊社手数料負担で返金いたします。
      </div>
    </div>
  </div>
  
  <div class="card mb-1">
    <div class="card-header" id="heading-104">
      <h5 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse-104" aria-expanded="false" aria-controls="collapse-104">
           <i class="fas fa-question-circle"></i> 画像を現像して郵送した場合代金は負担してくれますか？
      </h5>
    </div>
    <div id="collapse-104" class="collapse" aria-labelledby="heading-104" data-parent="#accordion-9">
      <div class="card-body">
        枯れ保障等に必要な画像はEメールにてお送りください。<br>
万が一、現像・郵送でお送りいただいた場合は、その代金はお客様ご負担でお願いしております。
<br><br>
現在デジタルカメラ、携帯電話カメラ、携帯電話メール、フリーメールが十分普及しています。<br>
もし持っていなかったり知識がなくとも周囲でもご協力可能な方がいらっしゃると思いますので、ご了承いただければと思います。<br><br>

もし添付方法が分からない場合は<br>
「画像　メール　添付　方法」<br>
で検索してくださいませ。
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






