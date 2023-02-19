<?php
require_once("./GameType.php");
require_once("./Board.php");
require_once("./Player.php");
require_once("./Utils.php");

session_start();
if(isset($_SESSION['main']) && !isset($_REQUEST["submitNewGame"])){
    $main = $_SESSION['main'];

    foreach($main->objects as $objName=>$obj){
        $$objName = $obj;
    }

    $numberOfPlayers = $main->numberOfPlayers;

    $turnOfPlayer = $main->turnOfPlayer;

    if($main->doubletsInRow == 3) {
        $main->doubletsInRow = 0;
    }
}
else{
    $main = new MainController;

    $main->objects['gameBoard'] = $gameBoard = new Board;
    $gameBoard->generateNewBoard();

    $main->numberOfPlayers = $numberOfPlayers = $_REQUEST['numberOfPlayers'];
    
    for($i=1;$i<=$main->numberOfPlayers;$i++){
        $playerId = "player_".$i;
        $main->objects[$playerId] = $$playerId = new Player;
        $$playerId->generateNewPlayer($gameBoard, $playerId);
    }

    $main->turnOfPlayer = $turnOfPlayer = 1;

    $main->doubletsInRow = 0;
}

if($_REQUEST){
    foreach($_REQUEST as $key=>$val){
        switch($key){
            case 'ajaxCall':
                switch($_REQUEST['ajaxCall']){
                    case 'showCellDetails':
                        $boardCellId = $_REQUEST['boardCellId'];
                        $playerId = $_REQUEST['playerId'];
                        $buyingPhase = boolval($_REQUEST['buyingPhase']);
                        $response['html'] = $gameBoard->cellDetailsHTML($boardCellId, $buyingPhase, $playerId, @$$playerId);
                        if($buyingPhase){
                            $cellOwner = $gameBoard->getCellOwner($boardCellId);
                            if($playerId != $cellOwner AND $cellOwner != 'bank'){
                                $rentPrice = $gameBoard->getCellCurrentRentPrice($boardCellId);
                                $$playerId->countAccountBalance('substract', $rentPrice);
                                $$cellOwner->countAccountBalance('add', $rentPrice);
                                $response['accountBalanceChanges'] = array(
                                    'playerId' => $playerId,
                                    'cellOwner' => $cellOwner,
                                    'number' => $rentPrice
                                );
                            }
                        }
                        echo json_encode($response);
                        exit();
                    case 'showRollDice':
                        $data = $gameBoard->prepareDiceHTML($_REQUEST['numberOfDices']);
                        echo $data;
                        exit();
                    case 'startNewGame':
                        echo Utils::startNewGameHTML();
                        exit();
                }
                break;
            case 'resetGame':
                session_destroy();
                header('Location: ./index.php?numberOfPlayers='.$main->numberOfPlayers);
                break;
            case 'rollDice':
                $playerId = "player_".$turnOfPlayer;

                $positionBeforeRoll = $$playerId->currentPosition;
                $gameBoard->changePlayerPosition($$playerId, Utils::sumOfDiceRolls($_REQUEST['rollDice']));
                if($$playerId->currentPosition < $positionBeforeRoll){
                    $$playerId->countAccountBalance('add',$gameBoard->passStartBonus);
                }

                $doublet = Utils::checkForDoublet($_REQUEST['rollDice']);

                if(!$doublet) {
                    Utils::nextTurn($main);
                }
                else $main->doubletsInRow++;
                break;
            case 'buyCell':
                $gameBoard->purchaseCell($_REQUEST['boardCellId'], ${$_REQUEST['playerId']});
                break;
        }
    }
}

/**
 * @author Roman Mohyła
 */
class MainController{
    public array $objects;

    public int $numberOfPlayers;

    public int $turnOfPlayer;

    public int $doubletsInRow;

    function playersDetailsHTML(){
        $currentPlayer = $this->objects['player_'.$this->turnOfPlayer];
        $invertedCurrentPlayerColor = Utils::blackOrWhiteColor($currentPlayer->colorHEX);
        $currentTurnStyle = 'background-color:#'.$currentPlayer->colorHEX.';border-color:#'.$currentPlayer->colorHEX.';color:#'.$invertedCurrentPlayerColor.';';
        
        $cells = $this->objects['gameBoard']->board['cells'];

        $html = '<div class="playersDetails">';
        $html .= '<div class="currentTurnInfo" style="'.$currentTurnStyle.'">Currrent turn:</div>';
        $html .= '<div class="currentTurnInfo" style="'.$currentTurnStyle.'">'.$currentPlayer->nick.'</div>';
        $html .= '<div class="currentTurnInfo" style="'.$currentTurnStyle.'">'.$currentPlayer->accountBalance.'$</div>';
        $html .= '<div class="currentTurnInfo" style="'.$currentTurnStyle.'">'.$currentPlayer->currentPosition.'</div>';
        for($i=1; $i<=$this->numberOfPlayers; $i++){
            $player = $this->objects['player_'.$i];

            $html .= '<div class="playerDetailsRow" style="border-bottom-color: #'.$player->colorHEX.'">';
                $html .= '<div class="playerDetailsCell" id="'.$player->id.'_nick"><div class="playerDetailLabel">Nick:</div> <span>'.$player->nick.'</span></div>';
                $html .= '<div class="playerDetailsCell" id="'.$player->id.'_money"><div class="playerDetailLabel">Money:</div> <span>'.$player->accountBalance.'</span>$</div>';
                $html .= '<div class="playerDetailsCell" id="'.$player->id.'_position"><div class="playerDetailLabel">Position:</div> <span>'.$cells[$player->currentPosition]['name'].'</span></div>';
                $html .= '<div class="playerDetailsCell" id="'.$player->id.'_pawn"><div class="playerDetailLabel">Pawn:</div> <span>'.$player->pawn.'</span></div>';
            $html .= '</div>';
        }
        $html .= '</div>';
        return $html;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="./board.css">
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script type="text/javascript" src="./utils.js"></script>
</head>
<body>
<div class="page">
    <?=Utils::menuHTML();?>
    <?=Utils::popupWindowHTML();?>
    <div class="pageContent">
        <?=$gameBoard->printBoard();?>
        <?=$main->playersDetailsHTML();?>
    </div>
</div>
</body>
</html>
<?php
if(isset($_REQUEST['rollDice'])){
    echo Utils::initializeBuyingPhase(${"player_".$turnOfPlayer}, $gameBoard, "player_".$turnOfPlayer);
}

$objNames = Utils::prepareArrayOfObjectsNames($main->objects);

foreach($objNames as $key=>$objName){
    $main->objects[$objName] = $$objName;
}
$_SESSION['main'] = $main;

?>