// Script 9.10 - modal.js

// Function called to open the window:
function openModal() {
    'use strict';
    // Remove the click handler on the open modal button:
    switch_off_edit_buttons('input');

    // Add a click handler to the close modal button:
    document.getElementById('closeModal').onclick = closeModal;
    
    // Make the modal DIV visible:
    document.getElementById('modal').style.display = 'inline-block';

    //Do anything fetching of script etc here

} // End of openModal() function.

// Function called to close the window:
function closeModal() {
    'use strict';

    // Add a click handler to the open modal button:
    switch_on_edit_buttons('input');

    // Make the modal DIV invisible:
    document.getElementById('modal').style.display = 'none';

    // Remove the click handler on the close modal button:
    document.getElementById('closeModal').onclick = null;
    
} // End of closeModal() function.

function switch_on_edit_buttons(tag_name){
    var tag = document.getElementsByTagName(tag_name);
    for(var i = 0;i < tag.length; i++){
	tag[i].onclick = match;
    }
}

function switch_off_edit_buttons(tag_name){
    var tag = document.getElementsByTagName(tag_name);
    for(var i = 0;i < tag.length; i++){
	tag[i].onclick = null;
    }

}

function match(){
	var regex = new RegExp("^button[0-9]+$");
	var result = regex.test(this.id);
	if(result){
		openModal();
	}
}


// Establish functionality on window load:
window.onload = function() {
    'use strict';
    // Add a click handler to the open modal button:
    switch_on_edit_buttons('input');
};
