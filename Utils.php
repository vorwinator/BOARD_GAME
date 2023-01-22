<?php

class Utils{

    static function prepareArrayOfObjectsNames($objects){
        foreach($objects as $objName=>$obj){
            $objNames[] = $objName;
        }

        return $objNames;
    }

    static function rollDice($numberOfDices){
        for($i=0;$i<$numberOfDices;$i++){
            $rollResult[] = rand(1,6);
        }
        
        return $rollResult;
    }

    static function countNextPosition($rollResult, $numberOfBoardCells, $currentPosition){
        return 
        $currentPosition + array_sum($rollResult) < $numberOfBoardCells? 
            $currentPosition + array_sum($rollResult): 
                $currentPosition + array_sum($rollResult) - $numberOfBoardCells;
    }
}