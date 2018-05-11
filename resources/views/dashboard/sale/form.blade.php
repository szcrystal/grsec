@extends('layouts.appDashBoard')

@section('content')
	
	<div class="text-left">
        <h1 class="Title">
        @if(isset($edit))
        会員情報
        @else
        会員情報
        @endif
        </h1>
        <p class="Description"></p>
    </div>

    <div class="row">
      <div class="col-sm-12 col-md-6 col-lg-6 col-xl-5 mb-5">
        <div class="bs-component clearfix">
        <div class="pull-left">
            <a href="{{ url('/dashboard/users') }}" class="btn bg-white border border-1 border-round border-secondary text-primary"><i class="fa fa-angle-double-left" aria-hidden="true"></i>一覧へ戻る</a>
        </div>
        </div>
    </div>
  </div>

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Error!!</strong> 追加できません<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
        
	@if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
        
    <div class="col-lg-12 mb-5">
        <form class="form-horizontal" role="form" method="POST" action="/dashboard/users/{{$id}}">

            {{ csrf_field() }}

            {{ method_field('PUT') }}


            	<div class="table-responsive">
                    <table class="table table-bordered">
                        <colgroup>
                            <col style="background: #dfdcdb; width: 25%;" class="cth">
                            <col style="background: #fefefe;" class="ctd">
                        </colgroup>
                        
                        <tbody>
                            <tr>
                                <th>ID</th>
                                <td>{{ $user->id }}</td>
                            </tr>

                            <tr>
                                <th>名前</th>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <th>フリガナ</th>
                                <td>{{ $user->hurigana }}</td>
                            </tr>
                            <tr>
                                <th>性別</th>
                                <td>{{ $user->gender }}</td>
                            </tr>
                            <tr>
                                <th>メールアドレス</th>
                                <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                            </tr>
                            
                            <tr>
                                <th>生年月日</th>
                                <td>{{$user->birth_year}}/{{$user->birth_month}}/{{$user->birth_day}}</td>
                            </tr>
                            <tr>
                                <th>郵便番号</th>
                                <td>{{ $user->post_num }}</td>
                            </tr>
                            <tr>
                                <th>都道府県</th>
                                <td>{{ $user-> prefecture }}</td>
                            </tr>
                            <tr>
                                <th>住所1</th>
                                <td>{{ $user->address_1 }}</td>
                            </tr>
                            <tr>
                                <th>住所2</th>
                                <td>{{ $user->address_2 }}</td>
                            </tr>
                            <tr>
                                <th>住所3</th>
                                <td>{{ $user->address_3 }}</td>
                            </tr>
                            <tr>
                                <th>電話番号</th>
                                <td>{{ $user->tel_num }}</a></td>
                            </tr>
                            
                            
                            <tr>
                                <th>メールマガジン</th>
                                <td>@if($user->magazine)
                                  <span class="text-info">登録済</span>
                                @else
                                <span class="text-warning">未登録</span>
                                @endif</td>
                            </tr>
                            <tr>
                                <th>登録日</th>
                            	<td>{{ Ctm::changeDate($user->created_at) }}</td>
                             </tr>   
                            
                            {{--
                            <tr>
                                <th>対応状況</th>
                                <td>
                                    <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                                        <div class="col-md-10">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="status" value="1"{{isset($contact) && $contact->status ? ' checked' : '' }}> 対応済みにする
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            --}}

                            <tr>

                            </tr>
                            

                        </tbody>
                    </table>
                </div>

				{{--
                <div class="form-group mb-5">
                    <div class="clearfix">
                        <button type="submit" class="btn btn-primary btn-block mx-auto w-btn w-25">更　新</button>
                    </div>
                </div>
                --}}

        </form>
    </div>

@endsection
