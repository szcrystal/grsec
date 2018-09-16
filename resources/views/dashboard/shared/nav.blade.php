<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="{{ url('dashboard') }}">グリーンロケット</a>
    
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarResponsive">
      
      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">

		{{--
		<li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
			<a class="nav-link" href="{{ url('/dashboard') }}">
            	<i class="fa fa-fw fa-dashboard"></i>
            	<span class="nav-link-text">Dashboard</span>
          	</a>
        </li>
        --}}
        
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="管理者設定">
            <a class="nav-link" href="{{ url('dashboard/register') }}" id="register">
            	<i class="fa fa-lock"></i>
                <span class="nav-link-text">管理者設定</span>
              </a>
        </li>
        
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="サイト設定">
            <a class="nav-link" href="{{ url('dashboard/settings') }}" id="settings">
            	<i class="fa fa-dashboard"></i>
                <span class="nav-link-text">サイト設定</span>
              </a>
        </li>
        
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="TOP設定">
            <a class="nav-link" href="{{ url('dashboard/top-settings') }}" id="topSettings">
            	<i class="fa fa-dashboard"></i>
                <span class="nav-link-text">TOP設定</span>
              </a>
        </li>
        
            
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="メールテンプレ">
              <a class="nav-link" href="{{ url('dashboard/mails') }}" id="mails">
              	<i class="fa fa-envelope"></i>
                <span class="nav-link-text">メールテンプレート</span>
            </a>
        </li>
        
        <div class="border border-secondary border-top-0 w-100 mx-auto"></div>
        
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="マスター登録">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseMaster" data-parent="#exampleAccordion">
            <i class="fa fa-pencil"></i>
            <span class="nav-link-text">マスター登録</span>
          </a>
          
          <ul class="sidenav-second-level collapse" id="collapseMaster" data-area="settings"><!--  collapse -->
          		
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="出荷元">
            	<a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#consignors" data-parent="#collapseMaster">
                    <i class="fa fa-fw fa-file"></i>
                    <span class="nav-link-text">出荷元</span>
                </a>
             	<ul class="sidenav-third-level collapse" id="consignors"><!-- class=" collapse" -->
                    <li>
                      <a href="{{ url('dashboard/consignors') }}">出荷元一覧</a>
                    </li>
                    <li>
                      <a href="{{ url('dashboard/consignors/create') }}">出荷元新規登録</a>
                    </li>
                </ul>
             </li> 
             
             <div class="border border-secondary border-top-0 w-75 mx-auto"></div>  
             
             <li class="nav-item" data-toggle="tooltip" data-placement="right" title="配送区分">
             	<a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#dgs" data-parent="#collapseMaster">
                    <i class="fa fa-truck"></i>
                    <span class="nav-link-text">配送区分</span>
                </a>
             	<ul class="sidenav-third-level collapse" id="dgs"><!-- class=" collapse" -->
              		<li>
                      <a href="{{ url('dashboard/dgs') }}">配送区分一覧</a>
                    </li>
                    <li>
                      <a href="{{ url('dashboard/dgs/create') }}">配送区分新規登録</a>
                    </li>
              	</ul>   
             </li>      
          	
           	<div class="border border-secondary border-top-0 w-75 mx-auto"></div>
              
              <li class="nav-item" data-toggle="tooltip" data-placement="right" title="カテゴリー">
        		<a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#categories" data-parent="#collapseMaster">
                    <i class="fa fa-align-left"></i>
                    <span class="nav-link-text">カテゴリー</span>
                </a>
                <ul class="sidenav-third-level collapse" id="categories"><!-- class=" collapse" -->
                    <li>
                      <a href="{{ url('dashboard/categories') }}">親カテゴリー一覧</a>
                    </li>
                    <li>
                      <a href="{{ url('dashboard/categories/create') }}">親カテゴリー新規追加</a>
                    </li>
                    
                    <li>
                      <a href="{{ url('dashboard/categories/sub') }}">子カテゴリー一覧</a>
                    </li>
                    <li>
                      <a href="{{ url('dashboard/categories/sub/create') }}">子カテゴリー新規追加</a>
                    </li>

                </ul>
            </li>
            
            <div class="border border-secondary border-top-0 w-75 mx-auto"></div>
            
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="タグ管理">
              <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#tags" data-parent="#collapseMaster">
                <i class="fa fa-tag"></i>
                <span class="nav-link-text">タグ管理</span>
              </a>
              <ul class="sidenav-third-level collapse" id="tags">
                <li>
                  <a href="{{ url('dashboard/tags') }}">タグ一覧</a>
                </li>
                <li>
                  <a href="{{ url('dashboard/tags/create') }}">タグ新規登録</a>
                </li>

              </ul>
            </li>
            
          </ul>
        </li>
        
        <div class="border border-secondary border-top-0 w-100 mx-auto"></div>
        
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="商品管理">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#items" data-parent="#exampleAccordion">
            <i class="fa fa-crop"></i>
            <span class="nav-link-text">商品管理</span>
          </a>
          <ul class="sidenav-second-level collapse" id="items">
            <li>
              <a href="{{ url('dashboard/items') }}">商品一覧</a>
            </li>
            <li>
              <a href="{{ url('dashboard/items/create') }}">商品新規登録</a>
            </li>
            {{--
            <li>
              <a href="{{ url('dashboard/items/pot-set') }}">ポットセット登録</a>
            </li>
            --}}
            
            {{--
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Example Pages">
                  <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseCate" data-parent="#collapseItem">
                    <i class="fa fa-fw fa-file"></i>
                    <span class="nav-link-text">カテゴリー</span>
                  </a>
                  <ul class="sidenav-third-level collapse" id="collapseCate">
                    <li>
                      <a href="{{ url('dashboard/categories') }}">カテゴリー一覧</a>
                    </li>
                    <li>
                      <a href="{{ url('dashboard/categories/create') }}">カテゴリー新規登録</a>
                    </li>

                  </ul>
                </li>
            --}}
            
            
            
          </ul>
        </li>
        
		
  		<div class="border border-secondary border-top-0 w-100 mx-auto"></div>
    
    	
        
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="売上管理">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#sales" data-parent="#exampleAccordion">
            <i class="fa fa-yen"></i>
            <span class="nav-link-text">売上管理</span>
          </a>
          <ul class="sidenav-second-level collapse" id="sales">
            <li>
              <a href="{{ url('dashboard/sales') }}">売上一覧</a>
            </li>


          </ul>
        </li> 
        
        <div class="border border-secondary border-top-0 w-100 mx-auto"></div>
        
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="会員管理">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#users" data-parent="#exampleAccordion">
            <i class="fa fa-user"></i>
            <span class="nav-link-text">会員管理</span>
          </a>
          <ul class="sidenav-second-level collapse" id="users">
            <li>
              <a href="{{ url('dashboard/users') }}">会員一覧</a>
            </li>
            <li>
              <a href="{{ url('dashboard/users?no_r=1') }}">非会員一覧</a>
            </li>
            {{--
            <li>
              <a href="{{ url('dashboard/users/create') }}">会員登録</a>
            </li>
            --}}

          </ul>
        </li> 
        
        <div class="border border-secondary border-top-0 w-100 mx-auto"></div>
        
        
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="固定ページ">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#fixes" data-parent="#exampleAccordion">
            <i class="fa fa-file"></i>
            <span class="nav-link-text">固定ページ</span>
          </a>
          <ul class="sidenav-second-level collapse" id="fixes">
            <li>
              <a href="{{ url('dashboard/fixes') }}">固定ページ一覧</a>
            </li>
            <li>
              <a href="{{ url('dashboard/fixes/create') }}">固定ページ追加</a>
            </li>

          </ul>
        </li>
        
        
        <div class="border border-secondary border-top-0 w-100 mx-auto"></div>
        
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="メルマガ">
          <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#magazines" data-parent="#exampleAccordion">
            <i class="fa fa-book"></i>
            <span class="nav-link-text">メルマガ</span>
          </a>
          <ul class="sidenav-second-level collapse" id="magazines">
            <li>
              <a href="{{ url('dashboard/magazines') }}">メルマガ一覧</a>
            </li>
            <li>
              <a href="{{ url('dashboard/magazines/create') }}">メルマガ新規作成</a>
            </li>

          </ul>
        </li>
        
        

		<div class="border border-secondary border-top-0 w-100 mx-auto"></div>
        
      	<li class="nav-item" data-toggle="tooltip" data-placement="right" title="お問合わせ">
          <a class="nav-link" href="{{ url('dashboard/contacts') }}">
            <i class="fa fa-question-circle"></i>
            <span class="nav-link-text">お問い合わせ一覧</span>
          </a>
          
        </li>  
        
      </ul>
      
      
      <ul class="navbar-nav sidenav-toggler">
        <li class="nav-item">
          <a class="nav-link text-center" id="sidenavToggler">
            <i class="fa fa-fw fa-angle-left"></i>
          </a>
        </li>
      </ul>
      
      
      
      <ul class="navbar-nav ml-auto">

		{{--
        <li class="nav-item">
          <a href="{{ url('dashboard/logout') }}" class="nav-link">
            <i class="fa fa-fw fa-sign-out"></i>Logout</a>
        </li>
        --}}

        <li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle mr-lg-2" id="adminDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            	<i class="fa fa-fw fa-user"></i> {{ Auth::guard('admin')->user()->name }}さん
            </a>

            <div style="left:initial; right:0;" class="dropdown-menu" aria-labelledby="adminDropdown">

                
                <a class="dropdown-item" href="{{ url('dashboard/logout') }}">
                    <span class="text-secondary">
                        <i class="fa fa-fw fa-sign-out"></i>Logout
                    </span>
                </a>

            </div>
            
        </li>
      </ul>


    </div>
</nav>
