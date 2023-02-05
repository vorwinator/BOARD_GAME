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

    public string $nick;

    function generateNewPlayer($gameBoard, $playerVarName){
        $this->colorHEX = $this->generatePlayerColor();
        $this->pawn = '<span id="'.$playerVarName.'_pawn" class="pawn" style="color:#'.$this->colorHEX.'">&#x2022;</span>';
        $this->countAccountBalance("gameStart", $gameBoard->numberOfBoardCells);
        $this->nick = $playerVarName;
        $gameBoard->modifyCellContent(0, $this->pawn, 'insertPlayerPawn');
    }

    function generatePlayerColor(){
        return substr('00000' . dechex(mt_rand(0, 0xffffff)), -6);
    }

    /**
     * @param string $mode - determines action type
     * @param float $number - value for calculations
     */
    function countAccountBalance($mode, $number){
        switch($mode){
            case "gameStart":
                $this->accountBalance = $number * 1000;
                break;
            case "substract":
                $this->accountBalance -= $number;
                break;
        }
    }
}