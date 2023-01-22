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
    
    $main->objects['player_1'] = $player_1 = new Player;
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
</head>
<body>
    <a href="./index.php">TEST</a>
<?php

$gameBoard->generateNewBoard();
$gameBoard->modifyCellContent(0, $player_1->pawn, 'insert');

$gameBoard->printBoard();

$objNames = Utils::prepareArrayOfObjectsNames($main->objects);

foreach($objNames as $key=>$objName){
    $main->objects[$objName] = $$objName;
}
$_SESSION['main'] = $main;
?>
    
</body>


</html>