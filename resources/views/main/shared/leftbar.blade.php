
<div id="left-bar">
    <div class="panel panel-default">

    <?php
    	extract(Ctm::getLeftbar());
        use App\TagGroup;
    ?>

            <div class="panel-body">
            	@if(Ctm::isAgent('sp'))
                    <div>
                        <ul class="navbar-nav mr-auto">
                            <!-- Authentication Links -->
                            @if (Auth::guest())
                                <li class="nav-link"><a href="{{ url('/login') }}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Login</a></li>
                                <li class="nav-link"><a href="{{ url('/register') }}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Register</a></li>
                            @else
                                <li class="dropdown nav-item">
                                    <a href="#" class="nav-link dropdown-toggle" id="dropdown01" data-toggle="dropdown" role="button" aria-expanded="false">
                                        {{ Auth::user()->name }} <span class="caret"></span>
                                    </a>

                                    <div class="dropdown-menu" aria-labelledby="dropdown01" role="menu">
                                        <a href="{{ url('/mypage') }}" class="dropdown-item"><i class="fa fa-angle-double-right" aria-hidden="true"></i> My Page</a>

                                        <a href="{{ url('/logout') }}" class="dropdown-item"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            <i class="fa fa-angle-double-right" aria-hidden="true"></i> Logout
                                        </a>

                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </div>
                                </li>
                            @endif
                            <li class="nav-link"><a href="{{ url('/contact') }}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Contact</a></li>
                        </ul>
                    </div>
                @endif

                <div>
                <h5>カテゴリ</h5>
                <ul class="no-list">
                @foreach($cateLeft as $val)
                    <li class="cate-list">
                        <i class="fa fa-circle" aria-hidden="true"></i>
                        <a href="{{url('/category/'.$val->slug)}}">{{$val->name}}</a>
                    </li>
                @endforeach

                </ul>
                </div>

                <div>
                <h5>人気タグ</h5>
                <ul class="no-list">
                @foreach($tagLeftRanks as $val)
                    <li class="rank-tag">
                        <i class="fa fa-tag" aria-hidden="true"></i><a href="{{url(TagGroup::find($val->group_id)->slug.'/'.$val->slug)}}">{{$val->name}}</a>
                    </li>
                @endforeach

                </ul>
                </div>

                <div class="adv">


                </div>

            </div>
        </div>

</div>


