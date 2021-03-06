/*
 * 	Additional function for this template
 *	Written by ThemePixels	
 *	http://themepixels.com/
 *
 *	Copyright (c) 2012 ThemePixels (http://themepixels.com)
 *	
 *	Built for Amanda Premium Responsive Admin Template
 *  http://themeforest.net/category/site-templates/admin-templates
 */
$(function(){


//$.noConflict();
								
	///// SHOW/HIDE USERDATA WHEN USERINFO IS CLICKED ///// 
	
	$('.userinfo').click(function(){
		if(!$(this).hasClass('active')) {
			$('.userinfodrop').show();
			$(this).addClass('active');
		} else {
			$('.userinfodrop').hide();
			$(this).removeClass('active');
		}
		//remove notification box if visible
		$('.notification').removeClass('active');
		$('.noticontent').remove();
		
		return false;
	});
	
	
	$('.show').click(function(){
		$url = $(this).attr('data_url');
		$('.centeriframe').attr('src',$url);
    })
	///// SHOW/HIDE NOTIFICATION /////
	
	$('.notification a').click(function(){
		var t = $(this);
		var url = t.attr('href');
		if(!$('.noticontent').is(':visible')) {
			$.post(url,function(data){
				t.parent().append('<div class="noticontent">'+data+'</div>');
			});
			//this will hide user info drop down when visible
			$('.userinfo').removeClass('active');
			$('.userinfodrop').hide();
		} else {
			t.parent().removeClass('active');
			$('.noticontent').hide();
		}
		return false;
	});
	
	
	
	///// SHOW/HIDE BOTH NOTIFICATION & USERINFO WHEN CLICKED OUTSIDE OF THIS ELEMENT /////
	$('.vernav > ul li a, .vernav2 > ul li a').each(function(){
		var url = $(this).attr('href');
		$(this).click(function(){
			if($(url).length > 0) {
				if($(url).is(':visible')) {
					if(!$(this).parents('div').hasClass('menucoll') &&
					   !$(this).parents('div').hasClass('menucoll2'))
							$(url).slideUp();
				} else {
					$('.vernav ul ul, .vernav2 ul ul').each(function(){
							$(this).slideUp();
					});
					if(!$(this).parents('div').hasClass('menucoll') &&
					   !$(this).parents('div').hasClass('menucoll2'))
							$(url).slideDown();
				}
				return false;	
			}
		});
	});
	
	$('.menucoll > ul > li, .menucoll2 > ul > li').on('mouseenter mouseleave',function(e){
		if(e.type == 'mouseenter') {
			$(this).addClass('hover');
			$(this).find('ul').show();	
		} else {
			$(this).removeClass('hover').find('ul').hide();	
		}
	});

	///// NOTIFICATION CONTENT /////
	
	$('.notitab a').on('click', function(){
		var id = $(this).attr('href');
		$('.notitab li').removeClass('current'); //reset current 
		$(this).parent().addClass('current');
		if(id == '#messages')
			$('#activities').hide();
		else
			$('#messages').hide();
			
		$(id).show();
		return false;
	});
	
	
	///// HORIZONTAL NAVIGATION (AJAX/INLINE DATA) /////	
	$('.hornav a').click(function(){
		
		//this is only applicable when window size below 450px
		if($(this).parents('.more').length == 0)
			$('.hornav li.more ul').hide();
		
		//remove current menu
		$('.hornav li').each(function(){
			$(this).removeClass('current');
		});
		
		$(this).parent().addClass('current');	// set as current menu
		
		var url = $(this).attr('href');
		if($(url).length > 0) {
			$('.contentwrapper .subcontent').hide();
			$(url).show();
		} else {
			$.post(url, function(data){
				$('#contentwrapper').html(data);
				$('.stdtable input:checkbox').uniform();	//restyling checkbox
			});
		}
		return false;
	});
	
	///// SEARCH BOX ON FOCUS /////
	$('#keyword').bind('focusin focusout', function(e){
		var t = $(this);
		if(e.type == 'focusin' && t.val() == 'Enter keyword(s)') {
			t.val('');
		} else if(e.type == 'focusout' && t.val() == '') {
			t.val('Enter keyword(s)');	
		}
	});
	
	
	///// NOTIFICATION CLOSE BUTTON /////
	
	$('.notibar .close').click(function(){
		$(this).parent().fadeOut(function(){
			$(this).remove();
		});
	});
	
	
	///// COLLAPSED/EXPAND LEFT MENU /////
	$('.togglemenu').click(function(){
		if(!$(this).hasClass('togglemenu_collapsed')) {
			
			//if($('.iconmenu').hasClass('vernav')) {
			if($('.vernav').length > 0) {
				if($('.vernav').hasClass('iconmenu')) {
					$('body').addClass('withmenucoll');
					$('.iconmenu').addClass('menucoll');
				} else {
					$('body').addClass('withmenucoll');
					$('.vernav').addClass('menucoll').find('ul').hide();
				}
			} else if($('.vernav2').length > 0) {
			//} else {
				$('body').addClass('withmenucoll2');
				$('.iconmenu').addClass('menucoll2');
			}
			
			$(this).addClass('togglemenu_collapsed');
			
			$('.iconmenu > ul > li > a').each(function(){
				var label = $(this).text();
				$('<li><span>'+label+'</span></li>')
					.insertBefore($(this).parent().find('ul li:first-child'));
			});
		} else {
			
			//if($('.iconmenu').hasClass('vernav')) {
			if($('.vernav').length > 0) {
				if($('.vernav').hasClass('iconmenu')) {
					$('body').removeClass('withmenucoll');
					$('.iconmenu').removeClass('menucoll');
				} else {
					$('body').removeClass('withmenucoll');
					$('.vernav').removeClass('menucoll').find('ul').show();
				}
			} else if($('.vernav2').length > 0) {	
			//} else {
				$('body').removeClass('withmenucoll2');
				$('.iconmenu').removeClass('menucoll2');
			}
			$(this).removeClass('togglemenu_collapsed');	
			
			$('.iconmenu ul ul li:first-child').remove();
		}
	});
	
	
	
	///// RESPONSIVE /////
	$('.searchicon').on('click',function(){
		$('.searchinner').show();
	});
	
	$('.searchcancel').on('click',function(){
		$('.searchinner').hide();
	});
	
	
	///// CHANGE THEME /////
	$('.changetheme a').click(function(){
		var c = $(this).attr('class');
		if($('#addonstyle').length == 0) {
			if(c != 'default') {
				$('head').append('<link id="addonstyle" rel="stylesheet" href="css/style.'+c+'.css" type="text/css" />');
				$.cookie("addonstyle", c, { path: '/' });
			}
		} else {
			if(c != 'default') {
				$('#addonstyle').attr('href','css/style.'+c+'.css');
				$.cookie("addonstyle", c, { path: '/' });
			} else {
				$('#addonstyle').remove();	
				$.cookie("addonstyle", null);
			}
		}
	});
	
	///// LOAD ADDON STYLE WHEN IT'S ALREADY SET /////
	if($.cookie('addonstyle')) {
		var c = $.cookie('addonstyle');
		if(c != '') {
			$('head').append('<link id="addonstyle" rel="stylesheet" href="css/style.'+c+'.css" type="text/css" />');
			$.cookie("addonstyle", c, { path: '/' });
		}
	}
	
   if(window.Event)
   {
	document.captureEvents(Event.MOUSEUP);
   }

   function nocontextmenu()
   {
        event.cancelBubble = true;
	event.returnValue  = false;
	return false;
   }

   function norightclick(e)
   {
	if(window.Event)
	{
		if(e.which == 2 || e.which == 3)
		{
			return false;
		}
	}else if(event.button == 2 || event.button ==3)
	{
		event.cancelBubble = true;
		event.returnValue  = false;
		return false;
	}
   }

   document.oncontextmenu  = nocontextmenu;
   document.onmousedown = norightclick;
});	
