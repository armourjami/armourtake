$(document).ready(function(){
	$('#user-dropdown').hover(function(){
		$('#drop-down').slideDown(100);
	}, function(){
		$('#drop-down').slideUp(100);
	});
	
	//fix font reset bug
	$('#main-css')[0].href = $('#main-css')[0].href;
});
