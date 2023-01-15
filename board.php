<?php

class board extends MainController{

    public string $board;

    static function generateNewBoard($tr = 3, $td = 10){
        if($tr < 3) $tr = 3;
        $boardCellId = 0;
        $board = '<table style="border: black solid 3px; height:500px; width:500px">';
        for($i = 0; $i < $tr; $i++){
            $board .= '<tr style="border: black solid 3px;">';
            for($j = 0; $j < $td; $j++){
                if($i == 0 || $i == $tr-1){
                    $board .= '<td id="Cell_'. $boardCellId .'" style="border: black solid 3px;"></td>';
                    $boardCellId++;
                }
                elseif($i != 0 && $i != $tr-1 && ($j == 0 || $j == 1)){
                    $board .= '<td id="Cell_'. $boardCellId .'" style="border: black solid 3px;"></td>';
                    $boardCellId++;
                }
                elseif($i==1 && $j==0){
                    $board .= '<td id="Cell_center" colspan="'. $td-2 .'" style="border: black solid 3px;"></td>';
                }
                else{
                    $board .= '<td></td>';
                }
            }
            $board .= "</tr>";
        }

        $board .="</table>";

        return $board;
    }
}