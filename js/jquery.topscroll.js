$(document).ready(function() {
	$('a[href="#top"]').click(
	    function (e) {
	    $('html, body').animate({scrollTop: '0px'}, 400);
	    return false;
	});
});