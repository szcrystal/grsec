<div class="panel orgPanel">
    <div class="panel-heading">
        <h2></h2>        
    </div>
    
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>ご確認ください!</strong><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
      
    <div class="panel-body">  
        <form class="form-horizontal" role="form" method="POST" action="{{getUrl('auth/login')}}">
        
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="form-group">
                <label class="control-label">ユーザーID</label>
            	<input type="email" class="form-control" name="user_id" value="{{ old('email') }}" placeholder="メールアドレスを入力して下さい"<?php echo isAgent('Trident')? '': ' autofocus'; ?>>
                
            </div>

            <div class="form-group">
                <label class="control-label">パスワード</label>
                <input type="password" class="form-control" name="password" placeholder="6文字以上入力して下さい">
            </div>
            
            <div class="clearfix form-group">
                <a class="pull-right" href="{{ getUrl('/password/email') }}"><span class="octicon octicon-issue-opened"></span>パスワードをお忘れですか？</a>
            </div>
            
            <div class="col-md-12">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="remember">ログイン状態を保存する
                    </label>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-12">
                    <button type="submit" class="conf-btn">ログイン</button>
                </div>
            </div>
        </form>
    </div>
    
</div>
