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
			if (all_checked()) {
				$('#register').removeAttr('disabled')
			}
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

	function all_checked() {
		if ($('#user_name').css('border') == '2px solid lightgreen' &&
		$('#user_email').css('border') == '2px solid lightgreen' &&
		$('#pwd').css('border') == '2px solid lightgreen' &&
		$('#cpwd').css('border') == '2px solid lightgreen') {
			return true;
		}else{
			return false;
		}

	}
});


/*
$(document).ready(function() {
	var form = {
		username : "",
		email : "",
		password : "",
		confirm_password : "",

		update : function() {
			this.username = $('#user_name').val();
			this.email = $('#user_email').val();
			this.password = $('#pwd').val();
			this.confirm_password = $('#cpwd').val();
		},

		validate : function() {
			if (this.username == "") return false;
			if (this.email == "") return false;
			return true;
		},

		submit : function () {
			$('#registerHere').submit();
		}
	};


	$('#register').click(function(e) {
		e.preventDefault();
		form.update();
		if (form.validate()) {
			form.submit();
		}
	});

});
*/