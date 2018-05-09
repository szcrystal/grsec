@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    @if (Auth::guest())
                        <li class="nav-link"><a href="{{ url('/login') }}">Login</a></li>
                        <li class="nav-link"><a href="{{ url('/register') }}">Register</a></li>
                    @else
                    	{{ Auth::user()->name }} <span class="caret"></span><br>
                        
                    	
                            <a href="{{ url('/mypage') }}" class="dropdown-item">マイページ</a>

                            <a href="{{ url('/logout') }}" class="dropdown-item"
                                onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                                ログアウト
                            </a>

                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                       
                    @endif


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
