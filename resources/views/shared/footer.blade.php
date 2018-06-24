<footer id="colop">
	<div class="container clear">

        <div class="float-left foot-wrap">
        	<div>
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'GREEN LOCKET') }}
                </a>
                <p>
                <?php //use Ctm; ?>
                @if(Ctm::isLocal())
                	<a href="{{ url('shop/clear') }}">CLEAR</a>
                 	<a href="{{ url('shop/cart') }}">cart</a>   
                @endif
                </p>
            </div>
        </div>

        <div class="float-left foot-wrap">
        	<?php
            	use App\Fix;
             	  
            	$fixes = Fix::where('open_status', 1)->orderBy('id', 'asc')->get();
            ?>
        	
			<ul>
   			@if($fixes)         
            	@foreach($fixes as $fix)
				<li><a href="{{ url($fix->slug) }}">
					@if($fix->sub_title != '')
                    {{ $fix->sub_title }}
                    @else
                    {{ $fix->title }}
                    @endif
                </a></li>
				@endforeach
    		@endif 
      			<li><a href="{{ url('contact') }}">お問い合わせ</a></li>                 
            </ul>
        </div>

        <div class="foot-company">
                <div class="calender">
                    <?php //dynamic_sidebar( 'foot-bar' ); ?>
                </div>
                
                <img src="{{ url('images/logo-name.png') }}">
                <img src="{{ url('images/logo-symbol.png') }}">
                 <address>
                      <h5>八進緑産株式会社</h5>
                    <table class="clear">      
                    <tr>
                        <th>営業時間</th>
                        <td>8：00-17：00</td>
                    </tr>
                    <tr>
                        <th>定休日</th>
                        <td>日曜・祝日</td>
                    </tr>
                    <tr>
                        <th>TEL</th>
                        <td>0299-53-0030</td>
                    </tr>
                    <tr>
                        <th>MAIL</th>
                        <td>info@8463.jp</td>
                        </tr>
                    <tr>
                        <th>所在地</th>
                        <td>〒311-3406<br>
                        茨城県小美玉市下吉影1627-1</td>
                    </tr>
                    </table>
                    
                  </address>
               <p>※圃場の見学には事前予約が必要です。<br>事前予約が無い場合、圃場見学ができないことがありますので、必ずメールや電話で予約のご連絡をお願いいたします。</p>   
            </div>
        </div>    
     
         <p><i class="fa fa-copyright" aria-hidden="true"></i> {{ config('app.name', 'GREEN LOCKET') }}</p>

    </div>

</footer>

<span class="top_btn"><i class="fa fa-angle-up"></i></span>

<!-- Scripts -->

      
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


