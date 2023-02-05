<?php
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
        $playerVarName = "player_".$i;
        $main->objects[$playerVarName] = $$playerVarName = new Player;
        $$playerVarName->generateNewPlayer($gameBoard, $playerVarName);
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
                        $playerVarName = $_REQUEST['playerVarName'];
                        $buyingPhase = boolval($_REQUEST['buyingPhase']);
                        echo $gameBoard->cellDetailsHTML($boardCellId, $buyingPhase, $playerVarName, $$playerVarName);
                        if($buyingPhase){
                            $cellOwner = $gameBoard->getCellOwner($boardCellId);
                            if($$playerVarName->playerId != $cellOwner AND $cellOwner != 'bank'){
                                $rentPrice = $gameBoard->getCellCurrentRentPrice($boardCellId);
                                $$playerVarName->countAccountBalance('substract', $rentPrice);
                                $$cellOwner->countAccountBalance('add', $rentPrice);
                            }
                        }
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
                $playerVarName = "player_".$turnOfPlayer;

                $gameBoard->changePlayerPosition($$playerVarName, Utils::sumOfDiceRolls($_REQUEST['rollDice']));

                $doublet = Utils::checkForDoublet($_REQUEST['rollDice']);

                if(!$doublet) {
                    Utils::nextTurn($main);
                }
                else $main->doubletsInRow++;
                break;
            case 'buyCell':
                $gameBoard->purchaseCell($_REQUEST['boardCellId'], ${$_REQUEST['playerVarName']});
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
<?php
echo Utils::menuHTML();
echo Utils::popupWindowHTML();
$gameBoard->printBoard();
if(isset($_REQUEST['rollDice'])){
    echo Utils::initializeBuyingPhase(${"player_".$turnOfPlayer}, $gameBoard, "player_".$turnOfPlayer);
}

$objNames = Utils::prepareArrayOfObjectsNames($main->objects);

foreach($objNames as $key=>$objName){
    $main->objects[$objName] = $$objName;
}
$_SESSION['main'] = $main;

?>
</div>
</body>


</html>