function spinner() {
	$('.spinner').show();
}

function spinner_off(){
	$('.spinner').hide();
}

// turn off artist links
$('h3').children('a').click(function(e) {
	e.preventDefault();
});

$(document).keydown(function(e){
	if (e.keyCode == 37) {
		$('#play-prev').click();
	}
});
$(document).keydown(function(e){
	if (e.keyCode == 39) {
		$('#play-next').click();
	}
});
$(document).keydown(function(e){
	if (e.keyCode == 32) {
		e.preventDefault();
		$('#play-all').click();
	}
});