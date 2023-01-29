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
}