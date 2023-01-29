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

    if($main->doublet == 3) {
        $main->doublet = 0;
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
        $$playerId->pawn = '<span id="'.$playerId.'_pawn" class="pawn">&#x2022;</span>';
        $gameBoard->modifyCellContent(0, $$playerId->pawn, 'insertPlayerPawn');
    }

    $main->turnOfPlayer = $turnOfPlayer = 1;

    $main->doublet = 0;
}

if($_REQUEST){
    foreach($_REQUEST as $key=>$val){
        switch($key){
            case 'ajaxCall':
                switch($_REQUEST['ajaxCall']){
                    case 'showCellDetails':
                        echo $gameBoard->cellDetailsHTML($_REQUEST['boardCellId']);
                        exit();
                    case 'showRollDice':
                        $data = $gameBoard->prepareDiceHTML($_REQUEST['numberOfDices']);
                        echo $data;
                        exit();
                    case 'startNewGame':
                        echo $main->startNewGameHTML();
                        exit();
                }
                break;
            case 'resetGame':
                session_destroy();
                header('Location: ./index.php?numberOfPlayers='.$main->numberOfPlayers);
                break;
            case 'rollDice':
                $playerId = "player_".$turnOfPlayer;
                $rollResultArray = explode(',',$_REQUEST['rollDice']);
                $rollResult = array_sum($rollResultArray);
                $gameBoard->modifyCellContent($$playerId->currentPosition, $$playerId->pawn, 'remove');
                $$playerId->currentPosition = Utils::countNextPosition($rollResult, $gameBoard->numberOfBoardCells, $$playerId->currentPosition); 
                $gameBoard->modifyCellContent($$playerId->currentPosition, $$playerId->pawn, 'insertPlayerPawn');

                $doublet = $main->checkForDoublet($rollResultArray);

                if(!$doublet) {
                    $main->turnOfPlayer = $turnOfPlayer >= $numberOfPlayers? 1: $turnOfPlayer+1;
                    $main->doublet = 0;
                }
                else $main->doublet++;
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

    public int $doublet;

    /**
     * @return string $html - html of form to start new game
     */
    function startNewGameHTML()
    {
        $html = '<form method="POST" action="./index.php">';
            $html .= '<label for="numberOfPlayers">Number of Players:</label>';
            $html .= '<input id="numberOfPlayers" type="int" name="numberOfPlayers"/>';
            $html .= '<input id="submitNewGame" type="submit" name="submitNewGame" value="Start game"/>';
        $html .= '</form>';

        return $html;
    }

    /**
     * @param array $rollResultArray [int] - all rolls made in turn
     * @return boolean doublet
     */
    function checkForDoublet($rollResultArray){
        if(count($rollResultArray)>1){
            foreach($rollResultArray as $key=>$val){
                if($rollResultArray[0] != $val){
                    return false;
                }
            }
        }
        return true;
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
    <a href="./index.php">TEST</a>
    <button onclick='showPopup("rollDice",2)'>ROLL</button>
    <button onclick='showPopup("startNewGame")'>NEW GAME</button>
    <a href="./index.php?resetGame">RESET</a>
<?php
$gameBoard->printBoard();

$objNames = Utils::prepareArrayOfObjectsNames($main->objects);

foreach($objNames as $key=>$objName){
    $main->objects[$objName] = $$objName;
}
$_SESSION['main'] = $main;
?>

<div id="popup" class="popup">
  <div id="popupContent" class="popupContent">
  </div>
</div>

</body>


</html>