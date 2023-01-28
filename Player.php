<?php

/**
 * @var string $color - represents color of a player
 * @var float $accountBalance - represents how much money player has
 * @var string $pawn - represents how player looks
 */
class Player extends MainController{

    public string $color;

    public float $accountBalance;

    public string $pawn;

    public int $currentPosition = 0;

    function generateNewPlayer($numberOfBoardCells){
        $this->accountBalance = $this->countAccountBalance($numberOfBoardCells);
    }

    function countAccountBalance($numberOfBoardCells = null){
        return $numberOfBoardCells * 1000;
    }
}