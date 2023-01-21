<?php
require_once("./Board.php");

class MainController{
    function __construct()
    {
        
    }
}

$gameBoard = new Board;

$gameBoard->generateNewBoard();

$gameBoard->printBoard();
