<?php
require_once("./Board.php");
require_once("./Player.php");

class MainController{
    function __construct()
    {
        
    }
}

$gameBoard = new Board;

$player_1 = new Player;

$gameBoard->generateNewBoard();

$gameBoard->printBoard();
