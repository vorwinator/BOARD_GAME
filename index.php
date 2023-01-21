<?php
require_once("./board.php");

class MainController{
    function __construct()
    {
        
    }
}

$gameBoard = new Board;

$gameBoard->generateNewBoard();

$gameBoard->printBoard();
