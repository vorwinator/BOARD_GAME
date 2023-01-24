<?php
require_once("./Board.php");
require_once("./Player.php");
require_once("./Utils.php");

session_start();
if(isset($_SESSION['main'])){
    $main = $_SESSION['main'];

    foreach($main->objects as $objName=>$obj){
        $$objName = $obj;
    }
}
else{
    $main = new MainController;

    $main->objects['gameBoard'] = $gameBoard = new Board;
    $gameBoard->generateNewBoard();
    
    $main->objects['player_1'] = $player_1 = new Player;
    $gameBoard->modifyCellContent(0, $player_1->pawn, 'insert');
}

if($_REQUEST){
    foreach($_REQUEST as $key=>$val){
        switch($key){
            case 'ajaxCall':
                switch($_REQUEST['ajaxCall']){
                    case 'getCellDetails':
                        echo $gameBoard->cellDetailsHTML($_REQUEST['boardCellId']);
                        exit();
                    case 'getRollDice':
                        $data = $gameBoard->prepareDiceHTML($_REQUEST['numberOfDices']);
                        echo $data;
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
                $gameBoard->modifyCellContent($player_1->currentPosition, $player_1->pawn, 'insert');
                break;
        }
    }
}

class MainController{
    public array $objects;

    function __construct()
    {
        
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
    <!-- <a href="./index.php?rollDice=2" onclick='showPopup("rollDice",2)'>ROLL</a> -->
    <button onclick='showPopup("rollDice",2)'>ROLL</button>
    <a href="./index.php?resetGame=2">RESET</a>
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