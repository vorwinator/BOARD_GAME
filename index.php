<?php
require_once("./board.php");

class MainController{
    function __construct()
    {
        
    }
}

$gameBoard = new board;

echo $gameBoard->generateNewBoard();
