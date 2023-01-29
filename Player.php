<?php

/**
 * @var string $color - represents color of a player
 * @var float $accountBalance - represents how much money player has
 * @var string $pawn - represents how player looks
 * @author Roman Mohyła
 */
class Player extends MainController{

    public string $color;

    public float $accountBalance;

    public string $pawn;

    public int $currentPosition = 0;

    function generateNewPlayer($gameBoard, $playerVarName){
        $this->pawn = '<span id="'.$playerVarName.'_pawn" class="pawn">&#x2022;</span>';
        $this->accountBalance = $this->countAccountBalance($gameBoard->numberOfBoardCells);
        $gameBoard->modifyCellContent(0, $this->pawn, 'insertPlayerPawn');
    }

    function countAccountBalance($numberOfBoardCells = null){
        return $numberOfBoardCells * 1000;
    }
}