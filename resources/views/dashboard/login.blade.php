@include('dashboard.shared.head')

<body class="bg-midLight">

<div class="container pt-5">
    <div class="card col-md-6 mx-auto mt-5 px-0"> <!-- ORG: .card-login -->
      
      <div class="card-header">
      	GREEN ROCKET DashBoard
      </div>
      
      <div class="card-body">
      	@if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>ログイン出来ません!!</strong> 
                <ul class="mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form class="form-horizontal" role="form" method="POST" action="">
        	{{ csrf_field() }}
         
            
          <div class="form-group">
            <label for="exampleInputEmail1">メールアドレス</label>
            <input type="email" class="form-control" name="email" value="{{ old('email') }}" autofocus>
          </div>
          
          <div class="form-group">
            <label for="exampleInputPassword1">パスワード</label>
            <input type="password" class="form-control" name="password" placeholder="8文字以上">
          </div>
          
          <div class="form-group">
            <div class="form-check text-right">
              <label class="form-check-label">
                <input type="checkbox" name="remember"> ログイン状態を保存する</label>
            </div>
          </div>
          
          <button type="submit" class="btn btn-primary btn-block mt-4 mx-auto w-25">ログイン</button>
        </form>
        
        {{--
            <div class="text-center">
              <a class="d-block small" href="forgot-password.html">Forgot Password?</a>
            </div>
        --}}
      
      </div>
    </div>
</div>

{{--
@include('dashboard.shared.foot')
--}}

</body>
</html>

