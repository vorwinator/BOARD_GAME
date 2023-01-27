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
}
else{
    $main = new MainController;

    $main->objects['gameBoard'] = $gameBoard = new Board;
    $gameBoard->generateNewBoard();
    
    for($i=1;$i<=$_REQUEST["numberOfPlayers"];$i++){
        $playerName = "player_".$i;
        $main->objects[$playerName] = $$playerName = new Player;
        $gameBoard->modifyCellContent(0, $$playerName->pawn, 'insertPlayerPawn');
    }
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
                header('Location: ./index.php');
                break;
            case 'rollDice':
                $rollResult = array_sum(explode(',',$_REQUEST['rollDice']));
                $gameBoard->modifyCellContent($player_1->currentPosition, $player_1->pawn, 'remove');
                $player_1->currentPosition = Utils::countNextPosition($rollResult, $gameBoard->numberOfBoardCells, $player_1->currentPosition); 
                $gameBoard->modifyCellContent($player_1->currentPosition, $player_1->pawn, 'insertPlayerPawn');
                break;
        }
    }
}

class MainController{
    public array $objects;

    function startNewGameHTML()
    {
        $html = '<form method="POST" action="./index.php">';
            $html .= '<label for="numberOfPlayers">Number of Players:</label>';
            $html .= '<input id="numberOfPlayers" type="int" name="numberOfPlayers"/>';
            $html .= '<input id="submitNewGame" type="submit" name="submitNewGame" value="Start game"/>';
        $html .= '</form>';

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