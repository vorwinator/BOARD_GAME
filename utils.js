
function showPopup(popupType, data) {
    var popup = document.getElementById("popup");
    var popupContent = document.getElementById("popupContent");
    switch (popupType) {
        case 'cellDetails':
            showCellDetails(data, popupContent, popup);
            break;
        case 'rollDice':
            showRollDice(data, popupContent, popup);
            break;
        case 'startNewGame':
            showStartNewGame(popupContent, popup);
            break;
    }
}

function showStartNewGame(popupContent, popup) {
    jQuery.ajax({
        url: './index.php?ajaxCall=startNewGame',
        success: function (data) {
            popupContent.innerHTML = data;
            popup.style.display = "block";
        }
    })
}

function showCellDetails(boardCellId, popupContent, popup) {
    jQuery.ajax({
        url: './index.php?ajaxCall=showCellDetails&boardCellId=' + boardCellId,
        success: function (data) {
            popupContent.innerHTML = data;
            popup.style.display = "block";
        }
    })
}

async function showRollDice(numberOfDices, popupContent, popup) {
    jQuery.ajax({
        url: './index.php?ajaxCall=showRollDice&numberOfDices=' + numberOfDices,
        success: function (data) {
            popupContent.innerHTML = '<div class="popupDices">' + data + '</div>';
            jQuery(".popupContent").css("background", (255, 255, 255, 0));
            jQuery(".popupContent").css("border", "none");
            jQuery(".popupDices").css("padding-left", "25%");
            popup.style.display = "block";
            const result = [];
            for (let i = 0; i < numberOfDices; i++){
                roll = getRandomInt(1, 7)
                rollDice(roll, i);
                result.push(roll);
            }
            redirectLikeLink("./index.php?rollDice=" + result);
        }
    })
}

async function redirectLikeLink(href, time = 2500) {
    await delay(time);
    window.location.href = href;
}

function delay(time) {
    return new Promise(resolve => setTimeout(resolve, time));
}

function getRandomInt(min, max) {
    min = Math.ceil(min);
    max = Math.floor(max);
    return Math.floor(Math.random() * (max - min) + min); // The maximum is exclusive and the minimum is inclusive
}
  

function closePopup(){
    var popup = document.getElementById("popup");
    popup.style.display = "none";
}

async function rollDice(rollResult, id) {
    await delay(500);
    switch (rollResult) {
        case 1:
            jQuery("#dice_"+id).css('transform','translateZ(-100px) rotateY(900deg) rotateX(990deg)')
            break;
        case 2:
            jQuery("#dice_"+id).css('transform','translateZ(-100px) rotateY(720deg) rotateX(900deg)') 
            break;
        case 3:
            jQuery("#dice_"+id).css('transform','translateZ(-100px) rotateY(630deg) rotateX(900deg)')
            break;
        case 4:
            jQuery("#dice_"+id).css('transform','translateZ(-100px) rotateY(900deg) rotateX(900deg)') 
            break;
        case 5:
            jQuery("#dice_"+id).css('transform','translateZ(-100px) rotateY(810deg) rotateX(900deg)') 
            break;
        case 6:
            jQuery("#dice_"+id).css('transform','translateZ(-100px) rotateY(1260deg) rotateX(1170deg)')
            break;
    }
}

window.onclick = function(event) {
    var popup = document.getElementById("popup");
    if (event.target == popup) {
        popup.style.display = "none";
    }
}

