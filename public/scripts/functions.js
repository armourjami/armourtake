var decodeHtml = function(html) {
    var txt = document.createElement("textarea");
    txt.innerHTML = html;
    return txt.value;
}

//Set up the modal buttons
var pageInit = function() {
	Modal.switch_on_edit_buttons('open-modal');
};
