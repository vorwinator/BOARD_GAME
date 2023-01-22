
function showPopup(boardCellId) {
    var popup = document.getElementById("popup");
    var popupContent = document.getElementById("popupContent");
    getCellDetails(boardCellId, popupContent);
    popup.style.display = "block";
}

function getCellDetails(boardCellId, popupContent) {
    jQuery.ajax({
        url: './index.php?ajaxCall=getCellDetails&boardCellId=' + boardCellId,
        success: function (data) {
            popupContent.innerHTML = data;
        }
    })
}

function closePopup(){
    var popup = document.getElementById("popup");
    popup.style.display = "none";
}

window.onclick = function(event) {
    var popup = document.getElementById("popup");
    if (event.target == popup) {
        popup.style.display = "none";
    }
}