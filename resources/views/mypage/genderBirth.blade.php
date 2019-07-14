<div class="table-responsive table-custom">
     <p class="mt-4 text-small">よろしければ以下もお答え下さい。</p>
     <table class="table table-borderd border">

     <tr>
        <fieldset  class="form-group">
         <th>性別</th>
           <td>
            <?php 
                 $arrs = array('男性', '女性');
             ?>  
                  
            @foreach($arrs as $arr) 
                  <?php
                   $checked = '';   
                if( Ctm::isOld() && old('user.gender') == $arr) {
                    $checked = ' checked';
                }
                else if(isset($user) && $user->gender == $arr) {
                //elseif(Session::has('all.data.user')  && session('all.data.user.gender') == $str) {
                    $checked = ' checked';
                }
                ?>
                  
                <label class="radio-inline pr-3{{ $errors->has('user.gender') ? ' is-invalid' : '' }}">
                    <input type="radio" name="user[gender]" value="{{ $arr }}"{{ $checked }}>{{ $arr }}
                </label>
            @endforeach
            
            @if ($errors->has('user.gender'))
                <div class="text-danger">
                    <span class="fa fa-exclamation form-control-feedback"></span>
                    <span>{{ $errors->first('user.gender') }}</span>
                </div>
            @endif
        </td>
        </fieldset>
     </tr>
    
    
     <tr class="form-group">
         <th>生年月日</th>
           <td class="wrap-birth">
               
            <select class="form-control rounded-0 select-first col-md-2 d-inline{{ $errors->has('user.birth_year') ? ' is-invalid' : '' }}" name="user[birth_year]">
                <option value="0" selected>年</option>
                <?php
                    $yNow = date('Y');
                    $y = 1900;
                ?>
                @while($y <= $yNow)
                    <?php
                        $selected = '';
                        if(Ctm::isOld()) {
                            if(old('user.birth_year') == $y)
                                $selected = ' selected';
                        }
                        else if(isset($user) && $user->birth_year) {
                            if($user->birth_year == $y) {
                            //if(Session::has('all.data.user')  && session('all.data.user.birth_year') == $y) {
                                $selected = ' selected';
                            }
                        }
                        else {
                            if($y == 1970) {
                                $selected = ' selected';
                            }
                        }
                    ?>
                    
                    <option value="{{ $y }}"{{ $selected }}>{{ $y }}</option>
                    
                    <?php $y++; ?>
                
                @endwhile
            </select>
            <span class="mr-2">年</span>
            
            @if ($errors->has('user.birth_year'))
                <div class="help-block text-danger">
                    <span class="fa fa-exclamation form-control-feedback"></span>
                    <span>{{ $errors->first('user.birth_year') }}</span>
                </div>
            @endif
            
            <select class="form-control rounded-0 select-first col-md-1 d-inline{{ $errors->has('user.birth_month') ? ' is-invalid' : '' }}" name="user[birth_month]">
                <option value="0" selected>月</option>
                <?php
                    $m = 1;
                ?>
                @while($m <= 12)
                    <?php
                        $selected = '';
                        if(Ctm::isOld()) {
                            if(old('user.birth_month') == $m)
                                $selected = ' selected';
                        }
                        else {
                            if(isset($user) && $user->birth_month == $m) {
                            //if(Session::has('all.data.user')  && session('all.data.user.birth_month') == $m) {
                                $selected = ' selected';
                            }
                        }
                    ?>
                    <option value="{{ $m }}"{{ $selected }}>{{ $m }}</option>
                    
                    <?php $m++; ?>
                
                @endwhile
            </select>
            <span class="mr-2">月</span>
            
            @if ($errors->has('user.birth_month'))
                <div class="help-block text-danger">
                    <span class="fa fa-exclamation form-control-feedback"></span>
                    <span>{{ $errors->first('user.birth_month') }}</span>
                </div>
            @endif
            
            <select class="form-control select-first col-md-1 d-inline{{ $errors->has('user.birth_day') ? ' is-invalid' : '' }}" name="user[birth_day]">
                <option value="0" selected>日</option>
                <?php
                    $d = 1;
                ?>
                @while($d <= 31)
                    <?php
                        $selected = '';
                        if(Ctm::isOld()) {
                            if(old('user.birth_day') == $d)
                                $selected = ' selected';
                        }
                        else {
                            if(isset($user) && $user->birth_day == $d) {
                            //if(Session::has('all.data.user')  && session('all.data.user.birth_day') == $d) {
                                $selected = ' selected';
                            }
                        }
                    ?>
                    <option value="{{ $d }}"{{ $selected }}>{{ $d }}</option>
                    
                    <?php $d++; ?>
                
                @endwhile
            </select>
            <span>日</span>
            
            @if ($errors->has('user.birth_day'))
                <div class="help-block text-danger">
                    <span class="fa fa-exclamation form-control-feedback"></span>
                    <span>{{ $errors->first('user.birth_day') }}</span>
                </div>
            @endif
            
        </td>
     </tr>
     
     </table>
</div>

