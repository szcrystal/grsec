(function($) {

var exe = (function() {

	return {
    
		opts: {
            crtClass: 'crnt',
            btnID: '.top_btn',
            all: 'html, body',
            animEnd: 'webkitAnimationEnd MSAnimationEnd oanimationend animationend', //mozAnimationEnd
            transitEnd: 'webkitTransitionEnd MSTransitionEnd otransitionend transitionend', //mozTransitionEnd 
        },
        
        scrollFunc: function() {
            var t = this,
                tb = $(t.opts.btnID);
            
            tb.css('display','none').on('click', function() {
                $(t.opts.all).animate({ scrollTop:0 }, 1200, 'easeOutExpo');
            });

            $(document).scroll(function(){

                if($(this).scrollTop() < 200)
                    tb.fadeOut(200);
                else 
                    tb.fadeIn(300);
            });
            
        },
        
        
        isAgent: function(user) {
            if( navigator.userAgent.indexOf(user) > 0 ) return true;
        },
        
        isLocal: function() {
        	if( location.port == 8006 ) return true;
        },
        
        isSpTab: function(arg) {

        	var spArr = ['iPhone','iPod','Mobile ','Mobile;','Windows Phone','IEMobile'];
            var tabArr = ['iPad','Kindle','Sony Tablet','Nexus 7','Android Tablet'];
            var arr = [];
            
            if(arg == 'sp')
            	arr = spArr;
            
            else if(arg == 'tab')
            	arr = tabArr;
            
            else
            	arr = spArr.concat(tabArr);
            
        	
            var th = this;
            var bool = false;
            
            arr.forEach(function(e, i, a) {
            	if(th.isAgent(e)) {
                	bool = true;
                    return; //Exit
                }
            });
            
            return bool;
        },
        
        toggleSp: function() {
        	$('.navbar .fa-search').on('click', function(){
            	$('.searchform').slideToggle(150);
            });
           
            var t;
            $('.navbar .fa-bars').on('click', function(){
            	var $leftbar = $('#left-bar');
                
                var h = $(window).height();
                $leftbar.find('.panel-body').css({height:h-60});

            	if($leftbar.is(':visible')) {
                	$leftbar.stop().animate({left:'-200px'}, 80, 'linear', function(){
                    	$(this).hide(0);
                        $('html,body').css({position:'static'}).scrollTop(t);
                    });
                }
                else {
                	t = $(window).scrollTop();
            		$leftbar.show(50, function(){
                    	$(this).stop().animate({left:0}, 100);
                        $('html,body').css({position:'fixed', top:-t}); //overflow:'hidden',
                    });
                }
                //$('.navbar-brand').text(t);
            });
        },
        
        
        put: function(tag, argText) {
            $(tag).text(argText);
            console.log("CheckText is『 %s 』" , argText);
        },
        
        autoComplete: function() {
           
            var data = [];
           
           	function addTagOnArea(target, text, groupId, val=0) {
           		var $tagArea = $(target).siblings('.tag-area');
           		var bool = true;
           
                $tagArea.find('.text-danger').remove();
           
                $tagArea.find('span').each(function(){
                	var preTag = $(this).text();

                	if(text == preTag) {
                    	bool = false;
                    }
                });
           
           		if(bool) {
                	//$tagArea.append('<span data-text="'+text+'" data-group="'+groupId+'" data-value="'+val+'"><em>' + text + '</em><i class="fa fa-times del-tag" aria-hidden="true"></i></span>');
                    $tagArea.append('<span><em>' + text + '</em><i class="fa fa-times del-tag" aria-hidden="true"></i></span>');
                       //$tagArea.append('<input type="hidden" name="'+groupId+'[]" value="'+text+'">');
                    $tagArea.append('<input type="hidden" name="tags[]" value="'+text+'">');
                }
                else {
           			$tagArea.prepend('<p class="text-danger"><i class="fa fa-exclamation" aria-hidden="true"></i> 既に追加されているタグです</p>');
                }
           
                return bool;
            }
           
            $(document).delegate('.del-tag', 'click', function(e){
                var $span = $(e.target).parent('span');
//                if($span.data('value'))
//                	data[$span.data('group')].splice($span.data('value'), 0, $span.data('text')); //or push
                
                $span.next('input').remove(); //先にinputをremove
                $span.fadeOut(150).remove();
            });
           
           
            $('.tag-control').each(function(){
            	var group = $(this).attr('id');
                var tagList = $(this).siblings('span').text();
                //$('.panel-heading').text(tagList);

                data[group] = tagList.split(',');
                var $tagInput = $('#' + group);
                
                $tagInput.autocomplete({
                    source: data[group],
                    autoFocus: true,
                    delay: 50,
                    minLength: 1,
                    
                    select: function(e, ui){
                    	var $num = data[group].indexOf(ui.item.value); //配列内の位置
                        var bool = addTagOnArea(e.target, ui.item.value, group, $num);
                        if(bool) {
//                        	if($num != -1)
//                            	data[group].splice($num, 1); //リストから削除
	                        
                            ui.item.value = '';
                        }
                    },
                    
                    response: function(e, ui){
                    	//$('.panel-heading').text(ui.content['label']);
                    	//if(ui.content == '') {
                        	$(e.target).siblings('.add-btn:hidden').fadeIn(50).css({display:'inline-block'});
                            //console.log('response');
                        //}
                        //else {
                        //	$(e.target).siblings('.add-btn').fadeOut(100);
                        //}
                        
                        //$(this).autocomplete('widget')
                    },
                    close: function(e, ui){
                    	/*
                    	if($(e.target).val().length > 1) {
                        	$(e.target).siblings('.add-btn').fadeIn(100).css({display:'inline-block'});
                        }
                        */
                    },
                    focus: function(e, ui){
						//console.log(ui.item);
                    },
                    search: function(e, ui){
                    },
                    change: function(e, ui) {
                    	console.log(ui);
                    },
                    
            	}); //autocomplete

                
                $tagInput.next('.add-btn').on('click keydown', function(event){
                	//console.log(event.which);
                	if (event.which == 1 || event.which == 13) {
                        var texts = $('#' + group).val();
                        
                        var bool = addTagOnArea('#' + group, texts, group);
                        if(bool) {
                        	$tagInput.val('');
                        	$(this).fadeOut(100);
                        }
                    }
                });
                
                $tagInput.on('keydown keyup', function(event){ //or keypress
                	if(event.which == 13) {//40
                    	if(event.type=='keydown') { // && $('.ui-menu').is(':hidden')
                        	var texts = $(this).val();
                            if(texts != '') {
                        		if(addTagOnArea(this, texts, group)) { //tag追加
                             		$(this).val('');
                                    //$(this).next('.add-btn:visible').fadeOut(50);
                                }
                             
                                $('.ui-autocomplete').hide();                             
                            }
                        }
                    	event.preventDefault();
                    }
                    
                    //if($(this).val().length < 2) { //event.which == 8 &&
                    if(event.type=='keyup' && $(this).val().length < 1) {
                		$(this).next('.add-btn').fadeOut(10);
                        $(this).siblings('.tag-area').find('.text-danger').remove();
                	}
                    
                    if(event.which != 13 && event.which != 8 && $(this).val().length > 0) {
                    	$(this).siblings('.add-btn:hidden').fadeIn(50).css({display:'inline-block'});
                    }
                });
            
            }); //each function
           
        },
        
        addClass: function() {
        	//$('.add-item').find('.item-panel').eq(0).addClass('first-panel');
            $('.item-panel').eq(0).css({border:'2px solid green'});
        },
        
        nl2br: function(str) {
            str = str.replace(/\r\n/g, "<br>");
            str = str.replace(/(\n|\r)/g, "<br>");
            return str;
        },
        
        
        
        eventItem: function() {
			
            //ここに追加 Btn
			$('.add-nav span').on('click', function() {
            	var $itemBtn = $(this).parent().siblings('.item-btn');
            	$itemBtn.nextAll('.item-form').children('div').fadeOut(100);
                
                if($itemBtn.is(':visible')) {
                	$itemBtn.slideUp(150);
                    $(this).fadeOut(70);
                }
                else {
                	$itemBtn.slideDown(150);
//                    $(this).fadeOut(70, function(){
//                    	$(this).next('span').fadeIn(70);
//                    });
                }
                
                $(this).fadeOut(70, function(){
                    $(this).siblings('span').fadeIn(70).css({display:'block'});
                });
                
                
            });
           
           	//add-item click
           	function eventItemBtn(name) {
                $('.i-'+name).on('click', function() {
                	//console.log($(this).parents('.item-btn').siblings('.item-form').find('.item-'+name));
                    
                    var $itemForm = $(this).parents('.item-btn').siblings('.item-form');
                    var $item = $itemForm.find('.item-'+name);
                    
                    $itemForm.children('div').not('.item-'+name).slideUp(100, 'linear', function() { //$this-> all div
                        $item.stop().slideToggle(100);
                        //$(this).queue([]).stop();
                    });
                });
            }
           
            eventItemBtn('title');
           	eventItemBtn('text');
            eventItemBtn('image');
           	eventItemBtn('link');
           
           
            //Link Check Btn
            $('.subm-check').on('click', function(e){
            	e.preventDefault();
                
            	var url = $(this).parent('div').find('.link-url').val(); //input type=text
                var $frame = $(this).parent('div').find('.link-frame');
                //console.log(url);
                
                $.ajax({
                    url: '/script/addLink.php',
                    type: "POST",
                    cache: false,
                    data: {
                      url: url,
                    },
                    //dataType: "json",
                    success: function(resData){
                    	//console.log(resData.image[0]);
                        $frame.html(resData).slideDown(100);
                    },
                    error: function(xhr, ts, err){
                        //resp(['']);
                    }
                });
            });
           
           
           //Thumbnail Upload ## This Useing
            $('.thumb-file').on('click', function(){
            	var $th = $(this);
                $th.on('change', function(e){
                	var file = e.target.files[0],
                    reader = new FileReader(),
                    $preview = $(this).parents('.thumb-wrap').find('.thumb-prev');
                    //t = this;

                    // 画像ファイル以外の場合は何もしない
                    if(file.type.indexOf("image") < 0){
                      return false;
                    }

                    // ファイル読み込みが完了した際のイベント登録
                    reader.onload = (function(file) {
                      return function(e) {
                        //既存のプレビューを削除
                        $preview.empty();
                        $th.siblings('input[type="hidden"]').val(0);
                        // .prevewの領域の中にロードした画像を表示するimageタグを追加
                        $preview.append($('<img>').attr({
                                  src: e.target.result,
                                  width: "100%",
                                  class: "img-fluid",
                                  title: file.name
                        }));
                        //console.log(file.name);
                        
                        $th.parents('.thumb-wrap').find('.del-spareimg').fadeIn(100);

                    };
                })(file);

                reader.readAsDataURL(file);
                });
            	
            });
            
            //削除を押した時
            $('.del-spareimg').on('click', function(){
                //console.log("aaa");
                
                $preview = $(this).parents('.thumb-wrap').find('.thumb-prev');
                $preview.empty();
                $preview.append('<span class="no-img">No Image</span>');
                
                $(this).siblings('input[type="hidden"]').val(1);
                $(this).siblings('.thumb-file').val('');
                $(this).fadeOut(100);
             
            });
            
            
            
            
           
           	
           
           
           	//ctrl-nav edit
            $('.edit-sec').on('click', function(e) {
            	var d = $(this).data('target');
                console.log(d);
                $(this).parents('section').find('.item-'+ d).slideToggle(100);
            
            });
           
            //ctrl-nav delete
            $('.del-sec').on('click', function() {
                var speed = 250;
                var $thisSec = $(this).parents('section');
                var itemId = $thisSec.find('.item-id-hidden').val();
                
				$thisSec.next('.item-panel').fadeOut(speed);
                $thisSec.fadeOut(speed, function(){
                	$(this).next('.item-panel').remove(); //追加用の空panelは必ずremoveする
                    
                	if(itemId > 0) //itemIdのあるもの（既存データ）はremoveせずdelete_keyをSetする。それ以外はremove
                    	$(this).find('.delete-hidden').val(1);
                    else
                    	$(this).remove();
                });
            });
           
            //ctrl-nav up
            $('.up-sec').on('click', function(e) {
            	var speed = 250;
                var $thisSec = $(this).parents('section');
                var $underPanel = $thisSec.next('.item-panel');
                var $target = $thisSec.prev('.item-panel').prev('section'); //section
                
                if($target.is('section')) { //is target
                    $underPanel.fadeOut(speed);
                    $thisSec.fadeOut(speed, function(){
                        $underPanel.insertBefore($target);
                        $thisSec.insertBefore($underPanel);
                        
                        $underPanel.fadeIn(150);
                        $thisSec.fadeIn(150);
                        
                    });
                }
                else {
                	console.log('nullnull');
                }
            
            });
           
            //ctrl-nav down
            $('.down-sec').on('click', function(e) {
            	var speed = 250;
                var $thisSec = $(this).parents('section');
                var $underPanel = $thisSec.next('.item-panel');
                var $target = $underPanel.next('section').next('.item-panel'); //item-panel
                //console.log($target);
                
                if($target.is('div')) { //is target
                    $underPanel.fadeOut(speed);
                    $thisSec.fadeOut(speed, function(){
                        $thisSec.insertAfter($target);
                        $underPanel.insertAfter($thisSec);
                        
                        $underPanel.fadeIn(150);
                        $thisSec.fadeIn(150);
                        
                    });
                }
                else {
                	console.log('nullnull');
                }
            
            });
           
            //$('.linksel-wrap').find('span').live('click', function(e){
            $(document).delegate('.linksel-wrap span', 'click', function() {
            	var $img = $(this).parent('div').prev('.linkimg-wrap').find('img:visible');
                var num;
                if($(this).is(':first-child')) {
                	if($img.prev().is('img')) {
                		$img.fadeOut(100);
                    	num = $img.prev('img').fadeIn(100).data('count');
                    }
                }
                else {
                	if($img.next().is('img')) {
                    	$img.fadeOut(100);
                		num = $img.next('img').fadeIn(100).data('count');
                    }
                }
                
                $(this).siblings('small').find('em').eq(0).text(num);
            });
           
        },
        
        
        mypagePost: function() {
        	var preventEvent = true;
           
        	$('input#keep, input#open, input#preview, input#drop').on('click', function(e){
            	$('.help-block').find('strong').text('');
                
            	if(preventEvent) {
                    e.preventDefault();
                    var action = $(this).parents('form').attr('action');
                    console.log(action);
                    var errors = [];
                    var hisu = '必須項目です';
                    var leng = '255文字以内で入力して下さい';
                    
                    function outputError (id, str) {
                        $('input#'+id).next('.help-block').find('strong').text(str);
                        return str;
                    }
                    
                    //title
                    if($('input#title').val() == '') {
                    	errors.push(outputError('title', hisu));
                    }
                    else if($('input#title').val().length > 255) {
                    	errors.push(outputError('title', leng));
                    }
                    //site
                    if($('input#movie_site').val() == '') {
                    	errors.push(outputError('movie_site', hisu));
                    }
                    else if($('input#movie_site').val().length > 255) {
                    	errors.push(outputError('movie_site', leng));
                    }
                    //url
                    if($('input#movie_url').val() == '') {
                    	errors.push(outputError('movie_url', hisu));
                    }
                    else if($('input#movie_url').val().length > 255) {
                    	errors.push(outputError('movie_url', leng));
                    }
                    //url unique
                    var urls = $('.movie-url').text();
                    var urlArr = urls.split(',');
                    var url = $('input#movie_url').val();
                    if(url.slice(-1) == '/') {
                    	url = url.slice(0, -1);
                    }
                    $.each(urlArr, function(key, elem) {
                    	if(url == elem) {
                        	errors.push(outputError('movie_url', '既存の動画サイトです'));
                        	return false;
                        }
                    });
                    
                    
                    if(!$('select#cate_id').val()) {
                    	$('select#cate_id').next('.help-block').find('strong').text('選択してください');
                    	errors.push('選択してください');
                    }
                    
                    //console.log(errors.length);
                    
                    if(!errors.length) {
                    	preventEvent = false;
                		$(this).trigger('click');
                    }
                }
                
            });
        },
        
        changeSelectRelation: function() {
        	var $select = $('.select-first');
         	var $select2 = $('.select-second'); 
          
//              var url = $(this).parent('div').find('.link-url').val(); //input type=text
//            var $frame = $(this).parent('div').find('.link-frame');
//            //console.log(url);     
         
         	$select.on('change', function(){
                var value = $(this).val();
                var _tokenVal = $('input[name=_token]').val();
                
                $(this).next('span').text('! 子カテゴリーも変更して下さい');
                
                //$('label').text(_tokenVal);

				//controllerでajax処理する場合、_tokenも送る必要がある
                $.ajax({
                    url: '/dashboard/items/script',
                    type: "POST",
                    cache: false,
                    data: {
                    	_token: _tokenVal,
                  		selectValue: value,
                    },
                    //dataType: "json",
                    success: function(resData){
                        //console.log(resData.subCates[1]);
                        var selectArr = resData.subCates;
                        
                        $select2.empty().append(
                        	$('<option>'+ '選択して下さい' + '</option>').attr({
                                  disabled: 1,
                                  selected: 1,
                            })
                        );
                        
                        $.each(selectArr, function(index, val){
                        	console.log(Object.keys(val));
                            
                        	$select2.append(
                         	   $('<option>' + Object.values(val) + '</option>').attr({
                                  value: Object.keys(val),
                                  
                        		})
                        	);
                    	}); //each
                        
                        //$frame.html(resData).slideDown(100);
                    },
                    error: function(xhr, ts, err){
                        //resp(['']);
                    }
                });
            
            });
        },
        
        openNav: function() {
        	
                if(location.pathname != "/") {
                	var loc = location.pathname.split("/")[2];

                 	console.log(loc);
                  	
                   	//$('a#'+ loc).addClass('thisActive');
                    
                    $('a[href="'+location.href + '"]').addClass('thisActive');
                    $('a[href="'+location.href + '"]').parents('ul').parent('li').children('a').addClass('thisActive').attr({href: '', }); 
                  
                       
                    $thisUl = $('ul#'+ loc);
                    console.log($thisUl);
                    
                    $thisUl.removeClass('collapse');
                    $thisUl.parent('li').children('a').addClass('thisActive').attr({href: ''});
                    //$thisUl.siblings('a').addClass('thisActive');
                    $thisUl.parents('ul').removeClass('collapse');
                    $thisUl.parents('ul').parent('li').children('a').addClass('thisActive').attr({href: ''});
                }
                
            
//            $collapse = $('.collapse');
//         
//             $collapse.show();
//              console.log($collapse.data('area'));      
        },
        
        
    } //return

})();


$(function(e){ //ready
    
    exe.autoComplete();
    
    exe.scrollFunc();
    exe.toggleSp();
  
  	//exe.addClass();
  
    //exe.addItem();
    exe.eventItem();
    //exe.mypagePost();
    
    exe.changeSelectRelation();
    
    exe.openNav();

});



})(jQuery);
