<?php
/**
 * @var array $board - contains all of current game board data
 * @var int $square - contains number of rows and columns 
 */
class Board extends MainController{

    public array $board;

    public int $square;

    /**
     * @param int $square - contains number of rows and columns
     */
    function generateNewBoard($square = 10){
        if($square < 3) $square = 3;
        $this->square = $square;
        $boardCellId = 0;
        $this->board['table']['startTable'] = '<table style="border: black solid 3px; height:500px; width:500px">';
        for($i = 0; $i < $square; $i++){
            $this->board['table']['row_'.$i] = '<tr style="border: black solid 3px;">';
            for($j = 0; $j < $square; $j++){
                if($i == 0 || $i == $square-1){//top and boottom
                    $this->generateCell($boardCellId);
                    $boardCellId++;
                }
                elseif($i != 0 && $i != $square-1 && ($j == 0 || $j == 1)){//left and right
                    $this->generateCell($boardCellId);
                    $boardCellId++;

                    if($i==1 && $j==0){//center
                        $this->board['table']['center'] = '<td id="Cell_center" colspan="'. $square-2 .'" rowspan="'. $square-2 .'" style="border: black solid 3px;"></td>';
                    }
                }
            }
            $this->board['table']['rowEnd_'.$i] = "</tr>";
        }

        $this->board['table']['endTable'] = "</table>";
    }

    /**
     * @param int $boardCellId - current cell id
     */
    function generateCell($boardCellId = null){
        $this->board['cells'][$boardCellId]['html'] = '<td id="Cell_'. $boardCellId .'" style="border: black solid 3px;"></td>';
        // $this->board['cells'][$boardCellId]['housingPrices'] = generateCellHousingPrices($boardCellId);
        // $this->board['cells'][$boardCellId]['rentPrices'] = generateCellRentPrices($boardCellId);
        // $this->board['cells'][$boardCellId]['extraRules'] = generateCellExtraRules($boardCellId);
    }

    /**
     * Refreshes board on every change
     */
    function refreshBoard(){
        $boardCellId = 0;
        $this->board['html'] = $this->board['table']['startTable'];
        for($i = 0; $i < $this->square; $i++){
            $this->board['html'] .= $this->board['table']['row_'.$i];
            for($j = 0; $j < $this->square; $j++){
                if($i == 0 || $i == $this->square-1){//top and boottom
                   $this->board['html'] .= $this->board['cells'][$boardCellId]['html'];
                    $boardCellId++;
                }
                elseif($i != 0 && $i != $this->square-1 && ($j == 0 || $j == 1)){//left and right
                    $this->board['html'] .= $this->board['cells'][$boardCellId]['html'];
                    $boardCellId++;

                    if($i==1 && $j==0){//center
                        $this->board['html'] .= $this->board['table']['center'];
                    }
                }
            }
            $this->board['html'] .= $this->board['table']['rowEnd_'.$i];
        }
        $this->board['html'] .= $this->board['table']['endTable'];
    }
    function printBoard(){
        $this->refreshBoard();
        echo $this->board['html'];
    }
}