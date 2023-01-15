<?php

class board extends MainController{

    public array $board;

    function generateNewBoard($tr = 10, $td = 10){
        if($tr < 3) $tr = 3;
        $boardCellId = 0;
        $this->board['html'] = '<table style="border: black solid 3px; height:500px; width:500px">';
        for($i = 0; $i < $tr; $i++){
            $this->board['html'] .= '<tr style="border: black solid 3px;">';
            for($j = 0; $j < $td; $j++){
                if($i == 0 || $i == $tr-1){
                    $this->board['html'] .= '<td id="Cell_'. $boardCellId .'" style="border: black solid 3px;"></td>';
                    $boardCellId++;
                }
                elseif($i != 0 && $i != $tr-1 && ($j == 0 || $j == 1)){
                    $this->board['html'] .= '<td id="Cell_'. $boardCellId .'" style="border: black solid 3px;"></td>';
                    $boardCellId++;
                }
                elseif($i==1 && $j==0){
                    $this->board['html'] .= '<td id="Cell_center" colspan="'. $td-2 .'" style="border: black solid 3px;"></td>';
                }
                else{
                    $this->board['html'] .= '<td></td>';
                }
            }
            $this->board['html'] .= "</tr>";
        }

        $this->board['html'] .="</table>";

        return $this->board['html'];
    }

    function generateCell($boardCellId = null){
        $this->board['html'] .= '<td id="Cell_'. $boardCellId .'" style="border: black solid 3px;"></td>';
        $this->board['cells'][$boardCellId]['housingPrices'] = generateCellHousingPrices($boardCellId);
        $this->board['cells'][$boardCellId]['rentPrices'] = generateCellRentPrices($boardCellId);
        $this->board['cells'][$boardCellId]['extraRules'] = generateCellExtraRules($boardCellId);
    }
}