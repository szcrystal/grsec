@extends('layouts.app')

@section('content')

        <div class="single model">

            <div class="thumb-frame text-center">
                @if(isset($model->model_thumb))
                    <img src="{{ Storage::url($model->model_thumb) }}" width="100%" height="auto">
                @else
                    <span class="no-img">No Image</span>
                @endif

            </div>


            <div class="col-md-12 panel-body">
                <div class="cont-wrap">

                    <h2>{{ $model -> name }}</h2>

					<div class="clear py-1">
                    <div class="table-responsive float-left">
                    	<table class="table table-bordered">
                            <colgroup>
                                <col class="cth">
                                <col class="ctd">
                            </colgroup>
                            
                            <tbody>
                            	<tr>
                                    <th>名前</th>
                                    <td>{{ $model->full_name }}</td>
                                </tr>
                                <tr>
                                    <th>ニックネーム</th>
                                    <td>{{ $model->name }}</td>
                                </tr>

                                <tr>
                                    <th>学校</th>
                                    <td>{{ $model->school }}</td>
                                </tr>

                                <tr>
                                    <th>Twitter</th>
                                    <td>
                                    	@if($twa->name != '')
                                    	<a href="https://twitter.com/{{ $twa->name }}" target="_brank">＠{{ $twa->name }}</a>
                                        @endif
                                    </td>
                                </tr>

                                <tr>
									<th>Instagram</th>
                                    <td><a href="https://www.instagram.com/{{ $model->instagram }}" target="_brank">{{ $model->instagram }}</a></td>
                                </tr>

                                <tr>
									<th>{{ $model->name }}が投稿した記事</th>
                                    <td>
                                    	@if($otherAtcl !== null)
										@foreach($otherAtcl as $oAtcl)
                                            <span class="rank-tag">
                                            	<i class="fa fa-file-text-o" aria-hidden="true"></i>
                                            	<a href="{{ url(Ctm::getAtclUrl($oAtcl->id)) }}">{{ $oAtcl->title }}</a>
                                            </span>
                                        @endforeach
                                        @endif
                                    </td>
                                </tr>

                            </tbody>
                		</table>
                    </div>



                        <div class="contents float-right">
                            {!! nl2br($model->per_info) !!}

                        </div>

                    </div>


                    <div class="snap-wrap clear">
                    	@if(Ctm::isAgent('sp'))
                        	@foreach($snaps as $snap)
                            	@if(isset($snap->snap_path) && $snap->snap_path != '')
                                <div style="background-image:url({{ Storage::url($snap->snap_path) }})" class="snap-sp">
                                </div>
                                @endif

                                @if($snap->ask != '' && $snap->answer != '')
                                    <div class="snap-meta">
                                        <h4><i class="fa fa-question-circle" aria-hidden="true"></i>{{ $snap->ask }}</h4>
                                        <p>{!! nl2br($snap->answer) !!}</p>
                                    </div>
                                @endif
                            @endforeach

                        @else
                            @foreach($snaps as $snap)
                                @if(isset($snap->snap_path) && $snap->snap_path != '')
                                    <div style="background-image:url({{ Storage::url($snap->snap_path) }})">

                                        @if($snap->ask != '' && $snap->answer != '')
                                        <div class="snap-meta">
                                            <h4><i class="fa fa-question-circle" aria-hidden="true"></i>{{ $snap->ask }}</h4>
                                            <p>{!! nl2br($snap->answer) !!}</p>
                                        </div>
                                        @endif

                                    </div>

                                @endif
                            @endforeach
                        @endif
                    </div>

                    <div style="" class="my-3 col-md-12">
                        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                        <!-- cute.campus2017 -->
                        <ins class="adsbygoogle"
                             style="display:block"
                             data-ad-client="ca-pub-8915257973665991"
                             data-ad-slot="7606073469"
                             data-ad-format="auto"></ins>
                        <script>
                        (adsbygoogle = window.adsbygoogle || []).push({});
                        </script>
                    </div>

                </div>



            </div><!-- panelbody -->



        </div>


@endsection
