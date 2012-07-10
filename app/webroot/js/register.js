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