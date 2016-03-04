$(document).ready(function(){
	$('#user-dropdown').hover(function(){
		$('#drop-down').slideDown(100);
	}, function(){
		$('#drop-down').slideUp(100);
	});
	
	//fix font reset bug
	$('#main-css')[0].href = $('#main-css')[0].href;
	
	$('#delete-submit').on('click', function(){
		var confirmed = confirm('Are you sure you want to delete?');
		//if 'Cancel' cancel submission
		if(!confirmed){
			return false;
		}
	});

	//Set up the modal buttons
	pageInit()
});
