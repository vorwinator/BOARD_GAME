<?php
/**
 * @var $board array - contains all of current game board data
 */
class board extends MainController{

    public array $board;

    /**
     * @param $square int - contains number of rows and columns
     */
    function generateNewBoard($square = 10){
        if($square < 3) $square = 3;
        $boardCellId = 0;
        $this->board['html'] = '<table style="border: black solid 3px; height:500px; width:500px">';
        for($i = 0; $i < $square; $i++){
            $this->board['html'] .= '<tr style="border: black solid 3px;">';
            for($j = 0; $j < $square; $j++){
                if($i == 0 || $i == $square-1){//top and boottom
                    $this->board['html'] .= '<td id="Cell_'. $boardCellId .'" style="border: black solid 3px;"></td>';
                    $boardCellId++;
                }
                elseif($i != 0 && $i != $square-1 && ($j == 0 || $j == 1)){//left and right
                    $this->board['html'] .= '<td id="Cell_'. $boardCellId .'" style="border: black solid 3px;"></td>';
                    $boardCellId++;

                    if($i==1 && $j==0){//center
                        $this->board['html'] .= '<td id="Cell_center" colspan="'. $square-2 .'" rowspan="'. $square-2 .'" style="border: black solid 3px;"></td>';
                    }
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