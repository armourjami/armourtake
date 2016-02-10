// Script 9.10 - modal.js

// Function called to open the window:
function openModal() {
    'use strict';

    // Add a click handler to the close modal button:
    $('#closeModal').on('click', closeModal);
    
    // Make the modal DIV visible:
    $('#modal').css('display', 'inline-block');

} // End of openModal() function.

// Function called to close the window:
function closeModal() {
    'use strict';

    // Make the modal DIV invisible:
    $('#modal').css('display', 'none');

    // Remove the click handler on the close modal button:
    $('#closeModal').on('click', null);
    
} // End of closeModal() function.

function switch_on_edit_buttons(id){
    var button = $('#' + id);
    button.on('click', openModal);
}

function switch_off_edit_buttons(id){
    var button = $('#' + id);
    button.on('click', null);
}

// Establish functionality on window load:
window.onload = function() {
    'use strict';
    // Add a click handler to the open modal button:
    switch_on_edit_buttons('add-new-ingredient-to-recipe');
};
