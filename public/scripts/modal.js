//Modal static class
//Design for one modal per page
var Modal = function(){
};
// Function called to open the window:
Modal.openModal = function () {
    'use strict';

    // Add a click handler to the close modal button:
    $('#closeModal').on('click', Modal.closeModal);
    // Make the modal DIV visible:
    $('#modal').css('display', 'inline-block');

};

// Function called to close the window:

Modal.closeModal = function () {
    'use strict';

    // Make the modal DIV invisible:
    $('#modal').css('display', 'none');

    // Remove the click handler on the close modal button:
    $('#closeModal').on('click', null);
    
};
Modal.switch_on_edit_buttons = function (id){
    var button = $('#' + id);
    button.on('click', Modal.openModal);
};

Modal.switch_off_edit_buttons = function (id){
    var button = $('#' + id);
    button.on('click', null);
};
