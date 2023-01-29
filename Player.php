<?php

/**
 * @var string $color - represents color of a player
 * @var float $accountBalance - represents how much money player has
 * @var string $pawn - represents how player looks
 * @author Roman Mohyła
 */
class Player extends MainController{

    public string $colorHEX;

    public float $accountBalance;

    public string $pawn;

    public int $currentPosition = 0;

    function generateNewPlayer($gameBoard, $playerVarName){
        $this->colorHEX = $this->generatePlayerColor();
        $this->pawn = '<span id="'.$playerVarName.'_pawn" class="pawn" style="color:#'.$this->colorHEX.'">&#x2022;</span>';
        $this->accountBalance = $this->countAccountBalance($gameBoard->numberOfBoardCells);
        $gameBoard->modifyCellContent(0, $this->pawn, 'insertPlayerPawn');
    }

    function generatePlayerColor(){
        return substr('00000' . dechex(mt_rand(0, 0xffffff)), -6);
    }

    function countAccountBalance($numberOfBoardCells = null){
        return $numberOfBoardCells * 1000;
    }
}