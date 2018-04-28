@extends('layouts.appDashBoard')

@section('content')
	
	<h3 class="page-header">問い合わせ編集</h3>

    <div class="bs-component clearfix">
        <div class="pull-left">
            <a href="{{ url('/dashboard/contacts') }}" class=""><i class="fa fa-angle-double-left" aria-hidden="true"></i>一覧へ戻る</a>
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
        
    <div class="well">
        <form class="form-horizontal" role="form" method="POST" action="/dashboard/contacts/{{$id}}">

            {{ csrf_field() }}

            {{ method_field('PUT') }}


            	<div class="table-responsive">
                    <table class="table table-bordered">
                        <colgroup>
                            <col style="background: #fefefe; width: 25%;" class="cth">
                            <col style="background: #fefefe;" class="ctd">
                        </colgroup>
                        
                        <tbody>
                            <tr>
                                <th>問合わせ日</th>
                                <td>
                                    {{ Ctm::changeDate($contact->created_at) }}
                                </td>
                            </tr>

                            <tr>
                                <th>カテゴリー</th>
                                <td>{{ $contact->ask_category }}</td>
                            </tr>
                            <tr>
                                <th>削除記事ID</th>
                                <td>{{ $contact->delete_id }}</td>
                            </tr>
                            <tr>
                                <th>削除記事タイトル</th>
                                <td>
                                @if($contact->delete_id)
                                {{ $atcl->find($contact->delete_id)->title }}
                                @endif
                                </td>
                            </tr>
                            <tr>
                                <th>名前</th>
                                <td>{{ $contact->user_name }}</td>
                            </tr>
                            <tr>
                                <th>メールアドレス</th>
                                <td><a href="mailto:{{ $contact->user_email }}">{{ $contact->user_email }}</a></td>
                            </tr>
                            <tr>
                                <th>コメント</th>
                                <td>{!! nl2br($contact->context) !!}</td>
                            </tr>
                            <tr>
                                <th>対応状況</th>
                                <td>
                                    <div class="form-group{{ $errors->has('done_status') ? ' has-error' : '' }}">
                                        <div class="col-md-10">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="done_status" value="1"{{isset($contact) && $contact->done_status ? ' checked' : '' }}> 対応済みにする
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr>

                            </tr>
                            

                        </tbody>
                    </table>
                </div>

                <div class="form-group">
                    <div class="col-md-4 col-md-offset-2">
                        <button type="submit" class="btn btn-primary center-block w-btn">更　新</button>
                    </div>
                </div>

        </form>
    </div>

@endsection
