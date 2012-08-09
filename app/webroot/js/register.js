/* --- registration parameters --- */
// enforced on frontend as well as backend
$(document).ready(function() {

	// needs to be at least 3 characters,
	// letters, numbers
	// can't already exist
	$('#user_name').keyup(function() {
		if (!$('#user_name').val().match('^[a-zA-Z0-9_-]{3,15}$')) {
			$('#user_name').css('border', '2px solid red');
		}else{
			$('#user_name').css('border', '2px solid lightgreen');
			if (all_checked()) {
				$('#register').removeAttr('disabled')
			}
		}
	});
	
	$('#user_email').keyup(function() {
		if (!$('#user_email').val().match('^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$')) {
			$('#user_email').css('border', '2px solid red');
		}else{
			$('#user_email').css('border', '2px solid lightgreen');
			$(this).addClass('checked');
		}
	});
	
	$('#pwd').keyup(function() {
		if (!$('#pwd').val().match('^[a-zA-Z0-9_-]{3,15}$')) {
			$('#pwd').css('border', '2px solid red');
		}else{
			$('#pwd').css('border', '2px solid lightgreen');
			if (all_checked()) {
				$('#register').removeAttr('disabled')
			}
		}
	});
	
	$('#cpwd').keyup(function() {
		if (!$('#cpwd').val().match('^[a-zA-Z0-9_-]{3,15}$') || $('#cpwd').val() != $('#pwd').val()) {
			$('#cpwd').css('border', '2px solid red');
		}else{
			$('#cpwd').css('border', '2px solid lightgreen');
			if (all_checked()) {
				$('#register').removeAttr('disabled')
			}
		}
	});
	
	$('#register').click(function() {
		e.preventDefault();
		form.submit();
		
	});

});
