<?php
require_once("./Board.php");
require_once("./Player.php");

class MainController{
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
<?php
$gameBoard = new Board;

$player_1 = new Player;

$gameBoard->generateNewBoard();
$gameBoard->modifyCellContent(0, $player_1->pawn, 'insert');
$gameBoard->modifyCellContent(0, $player_1->pawn, 'remove');

$gameBoard->printBoard();
?>
    
</body>


</html>