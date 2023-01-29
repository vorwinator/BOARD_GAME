<?php

/**
 * @author Roman Mohyła
 */
class Utils{

    /**
     * @param array $objects - array of objects
     * @return array[string] $objNames - key values of all objects
     */
    static function prepareArrayOfObjectsNames($objects){
        foreach($objects as $objName=>$obj){
            $objNames[] = $objName;
        }

        return $objNames;
    }

    /**
     * @param int $numberOfDices - how many rolls will be made
     * @return array[int] $rollResult - array of rolls results
     */
    static function rollDice($numberOfDices){
        for($i=0;$i<$numberOfDices;$i++){
            $rollResult[] = rand(1,6);
        }
        
        return $rollResult;
    }

    /**
     * @param int $rollResult - array_sum of made rolls
     * @param int $numberOfBoardCells
     * @param int $currentPosition - id of board cell that player is currently on
     * @return int - id of board cell that player will move to
     */
    static function countNextPosition($rollResult, $numberOfBoardCells, $currentPosition){
        return 
        $currentPosition + $rollResult < $numberOfBoardCells? 
            $currentPosition + $rollResult: 
                $currentPosition + $rollResult - $numberOfBoardCells;
    }

    /**
     * @return string $html - html of form to start new game
     */
    static function startNewGameHTML()
    {
        $html = '<span class="close" onclick="closePopup();">&times;</span>';
        $html .= '<form method="POST" action="./index.php">';
            $html .= '<label for="numberOfPlayers">Number of Players:</label>';
            $html .= '<input id="numberOfPlayers" type="int" name="numberOfPlayers"/>';
            $html .= '<input id="submitNewGame" type="submit" name="submitNewGame" value="Start game"/>';
        $html .= '</form>';

        return $html;
    }

    /**
     * @param array/string $rollResultArray [int] - all rolls made in turn
     * @return boolean doublet
     */
    static function checkForDoublet($rollResultArray){
        if(is_string($rollResultArray))
            $rollResultArray = explode(',',$rollResultArray);
        if(count($rollResultArray)>1){
            foreach($rollResultArray as $key=>$val){
                if($rollResultArray[0] != $val){
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * @param object $main - MainController object
     */
    static function nextTurn($main){
        $main->turnOfPlayer = $main->turnOfPlayer >= $main->numberOfPlayers? 1: $main->turnOfPlayer+1;
        $main->doublet = 0;
    }

    /**
     * generates empty popup for future use
     */
    static function popupWindowHTML(){
        return '
        <div id="popup" class="popup">
          <div id="popupContent" class="popupContent">
          </div>
        </div>
        ';
    }

    static function menuHTML(){
        return '
        <a href="./index.php">TEST</a>
        <button onclick=\'showPopup("rollDice",2)\'>ROLL</button>
        <button onclick=\'showPopup("startNewGame")\'>NEW GAME</button>
        <a href="./index.php?resetGame">RESET</a>
        ';
    }

    static function initializeBuyingPhase($player, $gameBoard, $playerVarName){
        return "<script>
        var data = ".json_encode(array('playerVarName'=>$playerVarName, 'playerColor'=>$player->colorHEX, 'currentPosition'=>$player->currentPosition, 'currentCell'=>$gameBoard->board["cells"][$player->currentPosition]))."
        showPopup('buyingPhase', data);
        </script>";
    }

    /**
     * @param string $rollDice - all rolls results separated by coma
     * @return int - sum of all rolls
     */
    static function sumOfDiceRolls($rollDice){
        return array_sum(explode(',',$rollDice));
    }
}