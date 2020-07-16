String.prototype.splice = function(idx, rem, str) {
    return this.slice(0, idx) + str + this.slice(idx + Math.abs(rem));
};

function activeTab(evt, tabClass) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(tabClass).style.display = "block";
    evt.currentTarget.className += " active";
}

let lastActiveElement = '';
function showKeywordsForInput(input_id) {
    lastActiveElement = input_id;
    $('#keywordsModal').modal('show');
}

function onKeywordClick(keyword) {
    let cursorPosition = $('#'+lastActiveElement).prop("selectionStart");
    console.log(cursorPosition);
    document.getElementById(lastActiveElement).value
        = document.getElementById(lastActiveElement).value.toString().splice(cursorPosition,0,keyword);
    $('#keywordsModal').modal('hide');
}

window.addEventListener('load', function() {
});