<?php
/**
 * @var array $board - contains all of current game board data
 * @var int $square - contains number of rows and columns 
 * @var int $numberOfBoardCells - contains number of cells on which players move around 
 */
class Board extends MainController{

    public array $board;

    public int $square;

    public int $numberOfBoardCells;

    /**
     * Generates new board for new game - should be run only once at the beginning of the game
     * @param int $square - contains number of rows and columns
     */
    function generateNewBoard($square = 10){
        if($square < 3) $square = 3;
        $this->square = $square;
        $this->numberOfBoardCells = $square * 4 - 4;
        $boardCellId = 0;

        $this->board['table']['startTable'] = '<table style="border: black solid 3px; height:500px; width:500px">';
        for($i = 0; $i < $square; $i++){//tr
            $this->board['table']['row_'.$i] = '<tr style="border: black solid 3px;">';
            for($j = 0; $j < $square; $j++){//td
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
     * generate general data for single cell
     * @param int $boardCellId - current cell id
     */
    function generateCell($boardCellId){
        $this->board['cells'][$boardCellId]['html'] = '<td id="Cell_'. $boardCellId .'" style="border: black solid 3px;"></td>';
        $this->board['cells'][$boardCellId]['housingPrices'] = $this->generateCellHousingPrices($boardCellId);
        $this->board['cells'][$boardCellId]['rentPrices'] = $this->generateCellRentPrices($boardCellId);
        $this->board['cells'][$boardCellId]['owner'] = "bank";
        $this->board['cells'][$boardCellId]['houseLevel'] = -1;
        // $this->board['cells'][$boardCellId]['extraRules'] = generateCellExtraRules($boardCellId);
    }

    /**
     * generates rent prices for single cell
     * @param int $boardCellId - current cell id
     */
    function generateCellRentPrices($boardCellId){
        $lineMultiplier = $this->countLineMultiplier($boardCellId);
        for($i=0;$i<5;$i++){
            $rentPrices[] = $this->countRentPrice($boardCellId, $lineMultiplier, $i+1);
        }

        return $rentPrices;
    }

    /**
     * @param int $boardCellId - current cell id
     * @param int $lineMultiplier - multiplier from section of the board game (left/top/right/down)
     * @param int $houseMultiplier - multiplier from house level
     */
    function countRentPrice($boardCellId, $lineMultiplier, $houseMultiplier){
        $boardCellMultiplier = $boardCellId % $this->numberOfBoardCells == 0? 1: $boardCellId % $this->numberOfBoardCells;
        return $lineMultiplier * $houseMultiplier * $boardCellMultiplier /90;
    }

    /**
     * generates housing prices for single cell
     * @param int $boardCellId - current cell id
     */
    function generateCellHousingPrices($boardCellId){
        $lineMultiplier = $this->countLineMultiplier($boardCellId);
        for($i=0;$i<5;$i++){
            $housingPrices[] = $this->countHousingPrice($boardCellId, $lineMultiplier, $i+1);
        }
        
        return $housingPrices;
    }

    /**
     * @param int $boardCellId - current cell id
     * @param int $lineMultiplier - multiplier from section of the board game (left/top/right/down)
     * @param int $houseMultiplier - multiplier from house level
     */
    function countHousingPrice($boardCellId, $lineMultiplier, $houseMultiplier){
        $boardCellMultiplier = $boardCellId % $this->numberOfBoardCells == 0? 1: $boardCellId % $this->numberOfBoardCells;
        return $lineMultiplier * $houseMultiplier * $boardCellMultiplier /9;
    }

    /**
     * @param int $boardCellId - current cell id
     */
    function countLineMultiplier($boardCellId){
        if($boardCellId < $this->numberOfBoardCells/4) //TODO nested short if not supported in this PHP version
         return 100 * $this->numberOfBoardCells/4;

          elseif($boardCellId < $this->numberOfBoardCells/4 * 2)
           return 100 * $this->numberOfBoardCells/4 * 1.2;

            elseif($boardCellId < $this->numberOfBoardCells/4 * 3)
             return 100 * $this->numberOfBoardCells/4 * 1.4;
             
              else return 100 * $this->numberOfBoardCells/4 * 1.6;
    }

    /**
     * Refreshes board['html']
     */
    function refreshBoard(){
        $boardCellId = 0;
        $this->board['html'] = $this->board['table']['startTable'];
        for($i = 0; $i < $this->square; $i++){//tr
            $this->board['html'] .= $this->board['table']['row_'.$i];
            for($j = 0; $j < $this->square; $j++){//td
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

    /**
     * show board for user
     */
    function printBoard(){
        $this->refreshBoard();
        echo $this->board['html'];
    }
}