/**
 * 
 * @param {string} popupType - what will be shown
 * @param {*} data - "I could be brown, I could be blue, I could be violet sky I could be hurtful, I could be purple, I could be anything you like" ~ MIKA - Grace Kelly
 */
function showPopup(popupType, data) {
    var popup = document.getElementById("popup");
    var popupContent = document.getElementById("popupContent");
    switch (popupType) {
        case 'cellDetails':
            showCellDetails(data, popupContent, popup, 0);
            break;
        case 'rollDice':
            showRollDice(data, popupContent, popup);
            break;
        case 'startNewGame':
            showStartNewGame(popupContent, popup);
            break;
        case 'buyingPhase':
            showCellDetails(data.currentPosition, popupContent, popup, 1, data.playerId);
            break;
    }
}

/**
 * 
 * @param {object} popupContent - content
 * @param {object} popup - background
 */
function showStartNewGame(popupContent, popup) {
    jQuery.ajax({
        url: './index.php?ajaxCall=startNewGame',
        success: function (data) {
            popupContent.innerHTML = data;
            popup.style.display = "block";
        }
    })
}

/**
 * 
 * @param {int} boardCellId
 * @param {object} popupContent - content
 * @param {object} popup - background
 * @param {boolean} buyingPhase - enable/disable buttons to buy
 * @param {string} playerId - name of player object in main controller
 */
function showCellDetails(boardCellId, popupContent, popup, buyingPhase, playerId = null) {
    jQuery.ajax({
        url: './index.php?ajaxCall=showCellDetails&boardCellId=' + boardCellId + '&buyingPhase=' + buyingPhase + '&playerId=' + playerId,
        dataType: 'json',
        success: function (response, result) {
            popupContent.innerHTML = response.html;
            popup.style.display = "block";
            document.getElementById("cell_" + boardCellId).scrollIntoView({ behavior: "smooth", block: "end", inline: "nearest" });
            turnPopupBackgroundTransparent();
            if (typeof response.accountBalanceChanges != "undefined") {
                showAccountBalanceChange("substract", response.accountBalanceChanges.number, response.accountBalanceChanges.playerId);
                showAccountBalanceChange("add", response.accountBalanceChanges.number, response.accountBalanceChanges.cellOwner);
            }
        }
    })
}

/**
 * 
 * @param {int} numberOfDices - how many rolls will be made
 * @param {object} popupContent - content
 * @param {object} popup - background
 */
async function showRollDice(numberOfDices, popupContent, popup) {
    jQuery.ajax({
        url: './index.php?ajaxCall=showRollDice&numberOfDices=' + numberOfDices,
        success: function (data) {
            popupContent.innerHTML = '<div class="popupDices">' + data + '</div>';
            turnPopupBackgroundInvisible();
            // jQuery(".popupContent").css("background", (255, 255, 255, 0));
            // jQuery(".popupContent").css("border", "none");
            jQuery(".popupDices").css("padding-left", "25%");
            popup.style.display = "block";
            const result = [];
            for (let i = 0; i < numberOfDices; i++){
                roll = getRandomInt(1, 7);
                rollDice(roll, i);
                result.push(roll);
            }
            redirectLikeLink("./index.php?rollDice=" + result);
        }
    })
}

function turnPopupBackgroundInvisible() {
    jQuery(".popupContent").css("background", (255, 255, 255, 0));
    jQuery(".popupContent").css("border", "none");
}

function turnPopupBackgroundTransparent() {
    jQuery("#popup").css('background', 'rgba(255, 255, 255, 0)');
    jQuery("#popupContent").css('background', 'rgba(255, 255, 255, 0.8)');
    jQuery("#popupContent").css("border", "none");
}

/**
 * 
 * @param {string} href - redirect to
 * @param {int} time - ms of delay
 */
async function redirectLikeLink(href, time = 2500) {
    await delay(time);
    window.location.href = href;
}

/**
 * 
 * @param {int} time - ms of delay
 * @returns timeout
 */
function delay(time) {
    return new Promise(resolve => setTimeout(resolve, time));
}

/**
 * 
 * @param {int} min - minimal value -> inclusive this one
 * @param {int} max - maximum value -> exclusive this one
 * @returns min =< int > max
 */
function getRandomInt(min, max) {
    min = Math.ceil(min);
    max = Math.floor(max);
    return Math.floor(Math.random() * (max - min) + min); // The maximum is exclusive and the minimum is inclusive
}
  
/**
 * make popup dissappear
 */
function closePopup(){
    var popup = document.getElementById("popup");
    popup.style.display = "none";
}

/**
 * rotate the dice to show result
 * @param {int} rollResult - result of dice roll
 * @param {int} id - dice id
 */
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

/**
 * Confirmation popup to purchase cell
 * @param {int} boardCellId 
 * @param {string} playerId 
 * @param {string} cellName 
 * @param {float} cellPurchasePrice 
 */
function buyCellPrompt(boardCellId, playerId, cellName, cellPurchasePrice) {
    if (confirm('You are going to buy ' + cellName + ' for a ' + cellPurchasePrice + '$')) {
        redirectLikeLink('./index.php?buyCell&boardCellId=' + boardCellId + '&playerId=' + playerId, 1);
    }
}

/**
 * Confirmation popup to purchase house
 * @param {int} boardCellId 
 * @param {string} playerId 
 * @param {string} cellName 
 * @param {float} housePurchasePrice 
 */
function buyHousePrompt(boardCellId, playerId, cellName, housePurchasePrice, houseLevel) {
    if (confirm('You are going to buy house level: ' + houseLevel + ' in ' + cellName + ' for a ' + housePurchasePrice + '$')) {
        redirectLikeLink('./index.php?buyHouse&boardCellId=' + boardCellId + '&playerId=' + playerId + '&houseLevel=' + houseLevel, 1);
    }
}

function showAccountBalanceChange(mode, number, playerId) {
    switch (mode) {
        case 'substract':
            document.getElementById(playerId + '_money').children[1].innerHTML += "<span class='failText'> - "+number+"</span>"; 
            break;
        case 'add':
            document.getElementById(playerId + '_money').children[1].innerHTML += "<span class='successText'> + "+number+"</span>";
            break;
    }
}

window.onclick = function(event) {
    var popup = document.getElementById("popup");
    var buyingPhase = document.getElementsByClassName("buyingPhase").length;
    if (event.target == popup) {
        if (buyingPhase) {
            if (confirm("Are You sure You want to leave popup?")) {
                popup.style.display = "none";
            }
        }
        else {
            popup.style.display = "none";
        }
    }
}

