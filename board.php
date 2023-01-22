<?php
/**
 * @var array $board - contains all of current game board data
 * @var int $square - contains number of rows and columns 
 * @var int $numberOfBoardCells - contains number of cells on which players move around 
 */
class Board extends MainController{

    public array $board;

    public int $square = 10;

    public int $numberOfBoardCells = 36;

    public string $gameType = 'standard'; //base for custom gameplays

    /**
     * Generates new board for new game - should be run only once at the beginning of the game
     * @param int $square - contains number of rows and columns
     */
    function generateNewBoard(){
        if($this->square < 3) $this->square = 3;
        $boardCellId = 0;
        $leftLine = 1;

        $this->board['table']['startTable'] = '<table class="board">';
        for($i = 0; $i < $this->square; $i++){//tr
            $this->board['table']['row_'.$i] = '<tr class="tr">';
            for($j = 0; $j < $this->square; $j++){//td
                if($i == 0 || $i == $this->square-1){//top and boottom
                    $this->generateCell($boardCellId);
                    $boardCellId++;
                }
                elseif($i != 0 && $i != $this->square-1 && ($j == 0 || $j == 1)){//left and right
                    if($j == 0){
                        $this->generateCell($this->numberOfBoardCells - $leftLine);
                        $leftLine++;
                    }
                    else{
                        $this->generateCell($boardCellId);
                        $boardCellId++;
                    }

                    if($i==1 && $j==0){//center
                        $this->board['table']['center'] = '<td id="Cell_center" colspan="'. $this->square-2 .'" rowspan="'. $this->square-2 .'"></td>';
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
        $this->board['cells'][$boardCellId]['html'] = '<td id="Cell_'. $boardCellId .'" class="Cell"></td>';
        $this->board['cells'][$boardCellId]['housingPrices'] = $this->generateCellHousingPrices($boardCellId);
        $this->board['cells'][$boardCellId]['rentPrices'] = $this->generateCellRentPrices($boardCellId);
        $this->board['cells'][$boardCellId]['purchasePrice'] = $this->generatePurchasePrice($boardCellId);
        $this->board['cells'][$boardCellId]['owner'] = "bank";
        $this->board['cells'][$boardCellId]['houseLevel'] = 0;
        // $this->board['cells'][$boardCellId]['extraRules'] = generateCellExtraRules($boardCellId);
    }

    /**
     * generates purchase price for single cell
     * @param int $boardCellId - current cell id
     */
    function generatePurchasePrice($boardCellId){
        $boardCellMultiplier = $boardCellId % $this->numberOfBoardCells == 0? 1: $boardCellId % $this->numberOfBoardCells;
        $lineMultiplier = $this->countLineMultiplier($boardCellId);
        return $lineMultiplier * $boardCellMultiplier /90 * 100;
    }

    /**
     * generates rent prices for single cell
     * @param int $boardCellId - current cell id
     */
    function generateCellRentPrices($boardCellId){
        $lineMultiplier = $this->countLineMultiplier($boardCellId);
        for($i=0;$i<6;$i++){
            $rentPrices[$i] = $this->countRentPrice($boardCellId, $lineMultiplier, $i);
        }

        return $rentPrices;
    }

    /**
     * generates housing prices for single cell
     * @param int $boardCellId - current cell id
     */
    function generateCellHousingPrices($boardCellId){
        $lineMultiplier = $this->countLineMultiplier($boardCellId);
        for($i=1;$i<6;$i++){
            $housingPrices[$i] = $this->countHousingPrice($boardCellId, $lineMultiplier, $i);
        }
        
        return $housingPrices;
    }

    /**
     * @param int $boardCellId - current cell id
     * @param int $lineMultiplier - multiplier from section of the board game (left/top/right/down)
     * @param int $houseMultiplier - multiplier from house level
     */
    function countRentPrice($boardCellId, $lineMultiplier, $houseMultiplier){
        $boardCellMultiplier = $boardCellId % $this->numberOfBoardCells == 0? 1: $boardCellId % $this->numberOfBoardCells;
        return 
        $lineMultiplier * $houseMultiplier * $boardCellMultiplier /90 == 0?
            $lineMultiplier * $boardCellMultiplier /180:
                $lineMultiplier * $houseMultiplier * $boardCellMultiplier /90;
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
     * @param int $boardCellId - current cell id
     * @param string $newContent - content that will be added to the cell
     * @param string $mode - determines what kind of modification will happen
     */
    function modifyCellContent($boardCellId, $modification, $mode){
        switch($mode){
            case 'insert':
                $html = explode("</td>", $this->board['cells'][$boardCellId]['html']);
                $this->board['cells'][$boardCellId]['html'] = $html[0].$modification.'</td>';
                break;
            case 'remove':
                $html = explode($modification, $this->board['cells'][$boardCellId]['html']);
                $this->board['cells'][$boardCellId]['html'] = $html[0].$html[1];
                break;
        }
    }

    /**
     * Refreshes board['html']
     */
    function refreshBoard(){
        $boardCellId = 0;
        $leftLine = 1;
        $this->board['html'] = $this->board['table']['startTable'];
        for($i = 0; $i < $this->square; $i++){//tr
            $this->board['html'] .= $this->board['table']['row_'.$i];
            for($j = 0; $j < $this->square; $j++){//td
                if($i == 0 || $i == $this->square-1){//top and boottom
                   $this->board['html'] .= $this->board['cells'][$boardCellId]['html'];
                    $boardCellId++;
                }
                elseif($i != 0 && $i != $this->square-1 && ($j == 0 || $j == 1)){//left and right
                    if($j == 0){
                        $this->board['html'] .= $this->board['cells'][$this->numberOfBoardCells - $leftLine]['html'];
                        $leftLine++;
                    }
                    else{
                        $this->board['html'] .= $this->board['cells'][$boardCellId]['html'];
                        $boardCellId++;
                    }

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