@extends('layouts.appDashBoard')

@section('content')
	
	<div class="text-left">
        <h1 class="Title">
        @if(isset($edit))
        お問い合わせ
        @else
        商品新規追加
        @endif
        </h1>
        <p class="Description"></p>
    </div>

    <div class="row">
      <div class="col-sm-12 col-md-6 col-lg-6 col-xl-5 mb-5">
        <div class="bs-component clearfix">
        <div class="pull-left">
            <a href="{{ url('/dashboard/contacts') }}" class="btn bg-white border border-1 border-round border-secondary text-primary"><i class="fa fa-angle-double-left" aria-hidden="true"></i>一覧へ戻る</a>
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
        <form class="form-horizontal" role="form" method="POST" action="/dashboard/contacts/{{$id}}">

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
                                <th>お問い合わせ日</th>
                                <td>
                                    {{ Ctm::changeDate($contact->created_at) }}
                                </td>
                            </tr>

                            <tr>
                                <th>種別</th>
                                <td>{{ $contact->ask_category }}</td>
                            </tr>
                            
                            <tr>
                                <th>名前</th>
                                <td>{{ $contact->name }}</td>
                            </tr>
                            <tr>
                                <th>メールアドレス</th>
                                <td><a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></td>
                            </tr>
                            <tr>
                                <th>内容</th>
                                <td>{!! nl2br($contact->comment) !!}</td>
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
