@extends('layouts.appDashBoard')

@section('content')
	
	<div class="text-left">
        <h1 class="Title"> Welcome to sb-admin! </h1>
        <p class="Description"> sb-Admin is an open source dashboard theme built with modular components.</p>
    </div>

    <div class="row">
      <div class="col-sm-12 col-md-6 col-lg-6 col-xl-5 mb-5">
        <div class="bs-component clearfix">
        <div class="pull-left">
            <a href="{{ url('/dashboard/articles') }}" class="btn btn-light border border-1 border-round border-secondary text-primary"><i class="fa fa-angle-double-left" aria-hidden="true"></i>一覧へ戻る</a>
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
        
    <div class="col-lg-10">
        <form class="form-horizontal" role="form" method="POST" action="/dashboard/articles/script">
			@if(isset($edit))
                <input type="hidden" name="edit_id" value="{{$id}}">
            @endif

            {{ csrf_field() }}


		<div class="row clearfix mb-4 thumb-wrap">
            <div class="float-left col-md-5 thumb-prev">
                @if(count(old()) > 0)
                    @if(old('thumbnail_outurl') != '' && old('thumb_choice'))
                    <img src="{{ Storage::url(old('thumbnail_outurl')) }}" class="img-fluid">
                    @elseif(isset($item) && $item->thumbnail)
                    <img src="{{ Storage::url($item->thumbnail) }}" class="img-fluid">
                    @else
                    <span class="no-img">No Image</span>
                    @endif
                @elseif(isset($item) && $item->thumbnail)
                <img src="{{ Storage::url($item->thumbnail) }}" class="img-fluid">
                @else
                <span class="no-img">No Image</span>
                @endif
            </div>

            <div class="float-left col-md-7">
                <fieldset class="form-group{{ $errors->has('main_img') ? ' is-invalid' : '' }}">
                    <label for="main_img">画像</label>
                    <input type="file" class="form-control-file thumb-file" id="main_img" name="main_img">
                </fieldset>
            </div>
        </div>

			<fieldset class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                <label>商品名</label>
                <input class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title') }}">

                @if ($errors->has('title'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('title') }}</span>
                    </div>
                @endif
            </fieldset>
            
            <div class="form-group{{ $errors->has('cate_id') ? ' has-error' : '' }}">
                <label>カテゴリー</label>
                <select class="form-control select-first" name="cate_id">
                    <option disabled selected>選択して下さい</option>
                    @foreach($cates as $cate)
                        <?php
                            $selected = '';
                            if(Ctm::isOld()) {
                                if(old('cate_id') == $cate->id)
                                    $selected = ' selected';
                            }
                            else {
                                if(isset($item) && $item->cate_id == $cate->id) {
                                    $selected = ' selected';
                                }
                            }
                        ?>
                        <option value="{{ $cate->id }}"{{ $selected }}>{{ $cate->name }}</option>
                    @endforeach
                </select>
                
                @if ($errors->has('cate_id'))
                    <span class="help-block text-warning">
                        <strong>{{ $errors->first('cate_id') }}</strong>
                    </span>
                @endif
                
            </div>
            

            <fieldset class="form-group{{ $errors->has('delivery_fee') ? ' has-error' : '' }}">
                <label for="delivery_fee" class="control-label">送料</label>
                <input class="form-control" name="delivery_fee" value="{{ old('delivery_fee') }}">
                <span>円</span>
                
                

                @if ($errors->has('delivery_fee'))
                    <div class="text-danger">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>{{ $errors->first('delivery_fee') }}</span>
                    </div>
                @endif
            </fieldset>


			<fieldset class="form-group{{ $errors->has('what_is') ? ' has-error' : '' }}">
                    <label for="story_text" class="control-label">What is</label>

                        <textarea id="what_is" type="text" class="form-control" name="what_is" value="{{ old('what_is') }}" rows="10"></textarea>

                        @if ($errors->has('what_is'))
                            <span class="help-block">
                                <strong>{{ $errors->first('what_is') }}</strong>
                            </span>
                        @endif
            </fieldset>
            
            <fieldset class="form-group{{ $errors->has('detail') ? ' has-error' : '' }}">
                    <label for="detail" class="control-label">詳細</label>

                        <textarea id="detail" type="text" class="form-control" name="detail" value="{{ old('detail') }}" rows="10"></textarea>

                        @if ($errors->has('detail'))
                            <span class="help-block">
                                <strong>{{ $errors->first('detail') }}</strong>
                            </span>
                        @endif
            </fieldset>
            
            <fieldset class="form-group{{ $errors->has('warning') ? ' has-error' : '' }}">
                    <label for="warning" class="control-label">ご注意</label>

                    <textarea id="warning" type="text" class="form-control" name="warning" value="{{ old('warning') }}" rows="10"></textarea>

                    @if ($errors->has('warning'))
                        <span class="help-block">
                            <strong>{{ $errors->first('warning') }}</strong>
                        </span>
                    @endif
            </fieldset>
            
            
            <div class="form-group">
                <div class="col-md-4 col-md-offset-3">
                    <button type="submit" class="btn btn-primary center-block w-btn"><span class="octicon octicon-sync"></span>更　新</button>
                </div>
            </div>


            <fieldset class="form-group">
                <label>Text area</label>
                <textarea class="form-control" rows="3"></textarea>
            </fieldset>

                <div class="form-group">
                    <label>Checkboxes</label>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" value=""> Checkbox 1
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" value=""> Checkbox 2
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" value=""> Checkbox 3
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label>Inline Checkboxes</label>
                    <label class="checkbox-inline">
                        <input type="checkbox">1
                    </label>
                    <label class="checkbox-inline">
                        <input type="checkbox">2
                    </label>
                    <label class="checkbox-inline">
                        <input type="checkbox">3
                    </label>
                </div>

                <fieldset class="form-group">
                    <label>Radio Buttons</label>
                    <div class="radio">
                        <label>
                            <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked> Radio 1
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2"> Radio 2
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="optionsRadios" id="optionsRadios3" value="option3"> Radio 3
                        </label>
                    </div>
                </fieldset>

                <fieldset class="form-group">
                    <label>Inline Radio Buttons</label>
                    <label class="radio-inline">
                        <input type="radio" name="optionsRadiosInline" id="optionsRadiosInline1" value="option1" checked>1
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="optionsRadiosInline" id="optionsRadiosInline2" value="option2">2
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="optionsRadiosInline" id="optionsRadiosInline3" value="option3">3
                    </label>
                </fieldset>

                <div class="form-group">
                    <label>Selects1</label>
                    <select class="form-control select-first" name="selectValue">
                    	<option disabled selected>選択して下さい</option>
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                    </select>
                    <span class="text-warning">&nbsp;</span>
                </div>
                
                <div class="form-group">
                    <label>Selects2</label>
                    <select class="form-control select-second" name="selectValue2[]">
                    	<option disabled selected>選択して下さい</option>
                        <option>aaa</option>
                        <option>bbb</option>
                        <option>ccc</option>
                        <option>ddd</option>
                        <option>eee</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Selects2</label>
                    <select class="form-control select-second" name="selectValue2[]">
                        <option disabled selected>選択して下さい</option>
                        <option>aaa</option>
                        <option>bbb</option>
                        <option>ccc</option>
                        <option>ddd</option>
                        <option>eee</option>
                    </select>
                </div>

                <fieldset class="form-group">
                    <label>Multiple Selects</label>
                    <select multiple class="form-control">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                    </select>
                </fieldset>
                
                <div class="clearfix tag-wrap">
                    <?php
                        $names = array();
                        $allNames = array();
                    ?>
                    
                    <fieldset class="tag-group form-group">
                        <label>タグ</label>
                        <div class="clearfix">
                            <input type="text" id="inputTag" class="form-control tag-control col-md-5" name="input-tag" value="" autocomplete="off" placeholder="Enter tag">
                            <div class="add-btn" tabindex="0">追加</div>
                            <span style="display:none;">{{ implode(',', $allTags) }}</span>
                            <div class="tag-area">
                                <?php
                                    if(count(old()) > 0) {
                                        $names = old($tags->slug);
                                    }
                                ?>

                                @if(isset($names))
                                    @foreach($names as $name)
                                        <span><em>{{ $name }}</em><i class="fa fa-times del-tag" aria-hidden="true"></i></span>
                                        <input type="hidden" name="tags[]" value="{{ $name }}">
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </fieldset>
                </div>

                <button type="submit" class="btn btn-success">Submit Button</button>
                <button type="reset" class="btn btn-primary">Reset Button</button>

            </form>

        </div>
        <div class="col-lg-6">
            <h1>Disabled Form States</h1>

            <form role="form">

                <fieldset disabled>

                    <div class="form-group">
                        <label for="disabledSelect">Disabled input</label>
                        <input class="form-control" id="disabledInput" type="text" placeholder="Disabled input" disabled>
                    </div>

                    <div class="form-group">
                        <label for="disabledSelect">Disabled select menu</label>
                        <select id="disabledSelect" class="form-control">
                            <option>Disabled select</option>
                        </select>
                    </div>

                    <div class="checkbox">
                        <label>
                            <input type="checkbox"> Disabled Checkbox
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary">Disabled Button</button>

                </fieldset>

            </form>
            <br />

            <h1>Form Validation</h1>

            <form role="form">

                <div class="form-group has-success">
                    <label class="form-control-label" for="inputSuccess">Input with success</label>
                    <input type="text" class="form-control form-control-success border-success" id="inputSuccess">
                    <div class="text-success">
                        <span class="fa fa-check form-control-feedback"></span>
                        <span>Success message</span>
                    </div>
                </div>

                <div class="form-group has-warning">
                    <label class="form-control-label" for="inputWarning">Input with warning</label>
                    <input type="text" class="form-control form-control-warning border-warning" id="inputWarning">
                    <div class="text-warning">
                        <span class="fa fa-exclamation form-control-feedback"></span>
                        <span>Warning message</span>
                    </div>
                </div>

                <div class="form-group has-danger">
                    <label class="form-control-label" for="inputError">Input with danger</label>
                    <input type="text" class="form-control form-control-danger border-danger" id="inputError">
                    <div class="text-danger">
                        <span class="fa fa-times form-control-feedback"></span>
                        <span>Error message</span>
                    </div>
                </div>

            </form>

            <h1>Input Groups</h1>

            <form role="form">

                <div class="form-group input-group">
                    <span class="input-group-addon">@</span>
                    <input type="text" class="form-control" placeholder="Username">
                </div>

                <div class="form-group input-group">
                    <input type="text" class="form-control">
                    <span class="input-group-addon">.00</span>
                </div>

                <div class="form-group input-group">
                    <span class="input-group-addon"><i class="fa fa-eur"></i></span>
                    <input type="text" class="form-control" placeholder="Font Awesome Icon">
                </div>

                <div class="form-group input-group">
                    <span class="input-group-addon">$</span>
                    <input type="text" class="form-control">
                    <span class="input-group-addon">.00</span>
                </div>

                <div class="form-group input-group">
                    <input type="text" class="form-control">
                    <span class="input-group-btn">
                    	<button class="btn btn-secondary" type="button"><i class="fa fa-search"></i>更　新</button>
                    </span>
                </div>






          <div class="form-group">
            <div class="col-md-4 col-md-offset-3">
                <button type="submit" class="btn btn-primary center-block w-btn"><span class="octicon octicon-sync"></span>更　新</button>
            </div>
        </div>

        </form>

    </div>

    

@endsection
