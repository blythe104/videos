	$('#loginbutton').click(function(){
		if($('#username').val() == '' && $('#password').val() == '') {
			$('.nousername').fadeIn();
			$('.nopassword').hide();
			return false;	
		}
		if($('#username').val() != '' && $('#password').val() == '') {
			$('.nopassword').fadeIn().find('.userlogged h4, .userlogged a span').text($('#username').val());
			$('.nousername,.username').hide();
			return false;;
		}

	
	var username =  $('#username').val();
	var password = $('#password').val();
	$.post('Login/Login',{username:username,password:password},function(data){
		console.log(data);
		alert('haha');
		if(data.status)
		{
			alert(data.msg);	
		}else{
			alert(data.msg);
		}

		},json);
	});
	
