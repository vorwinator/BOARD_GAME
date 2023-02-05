<?php
/**
 * @var array $board - contains all of current game board data
 * @var int $square - contains number of rows and columns 
 * @var int $numberOfBoardCells - contains number of cells on which players move around 
 * @author Roman Mohyła
 */
class Board extends MainController{

    public array $board;

    public int $square = 10;

    public int $numberOfBoardCells = 36;

    public string $gameType = 'standard'; //base for custom gameplays

    /**
     * Generates new board for new game - should be run only once at the beginning of the game
     */
    function generateNewBoard(){
        if($this->square < 3) $this->square = 3;
        $boardCellId = 0;
        $leftLine = $this->numberOfBoardCells-1;
        $bottomLine = 3*$this->square-3;

        $this->board['table']['startTable'] = '<table class="board">';
        for($i = 0; $i < $this->square; $i++){//tr
            $this->board['table']['row_'.$i] = '<tr class="tr">';
            for($j = 0; $j < $this->square; $j++){//td
                if($i == 0 || $i == $this->square-1){//top and boottom
                    if($i == $this->square-1){//bottom
                        $this->generateCell($bottomLine);
                        $bottomLine--;
                    }
                    else{//top
                        $this->generateCell($boardCellId);
                        $boardCellId++;
                    }
                }
                elseif($i != 0 && $i != $this->square-1 && ($j == 0 || $j == 1)){//left and right
                    if($j == 0){//left
                        $this->generateCell($leftLine);
                        $leftLine--;
                    }
                    else{//right
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
        $this->board['cells'][$boardCellId] = Array(
            'html' => '<td id="Cell_'. $boardCellId .'" class="Cell" onclick="showPopup(\'cellDetails\','.$boardCellId.');"><div class="cellPawns"></div></td>',
            'housingPrices' => $this->generateCellHousingPrices($boardCellId),
            'rentPrices' => $this->generateCellRentPrices($boardCellId),
            'purchasePrice' => $this->generatePurchasePrice($boardCellId),
            'name' => "Cell_".$boardCellId,
            'owner' => 'bank',
            'houseLevel' => 0,
            // 'extraRules' => $this->generateCellExtraRules($boardCellId),
        );
    }

    /**
     * generates purchase price for single cell
     * @param int $boardCellId - current cell id
     */
    function generatePurchasePrice($boardCellId){
        $boardCellMultiplier = $boardCellId % $this->numberOfBoardCells == 0? 1: $boardCellId % $this->numberOfBoardCells;
        $lineMultiplier = $this->countLineMultiplier($boardCellId);
        return $lineMultiplier * $boardCellMultiplier /90 * 5;
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
     * @param string $modification - base value of upcoming modification
     * @param string $mode - determines what kind of modification will happen
     */
    function modifyCellContent($boardCellId, $modification, $mode){
        $cell = $this->board['cells'][$boardCellId];

        switch($mode){
            case 'insertPlayerPawn':
                $html = explode('<div class="cellPawns">', $cell['html']);
                $cell['html'] = $html[0].'<div class="cellPawns">'.$modification.$html[1];
                break;
            case 'remove':
                $html = explode($modification, $cell['html']);
                $cell['html'] = $html[0].$html[1];
                break;
            case 'borderColor':
                $html = explode('>', $cell['html'], 2);

                if(stristr($html[0], 'border-color: #')){
                    $html_2 = explode('border-color: #', $html[0]);
                    $modification = 'border-color: #'.$modification.';';
                    $html[0] = str_replace('border-color: #', $modification, $html[0]).'>';
                }
                elseif(stristr($html[0], 'style=')){
                    $html_2 = explode('style="', $html[0]);
                    $modification = 'style="border-color: #'.$modification.';';
                    $html[0] = str_replace('style="', $modification, $html[0]).'>';
                }
                else{
                    $modification = ' style="border-color: #'.$modification.';">';
                    $html[0] .= $modification;
                }

                $cell['html'] = $html[0].$html[1];
                break;
        }

        $this->board['cells'][$boardCellId] = $cell;
    }

    /**
     * @param object $playerId
     * @param int $rollResult - sum of all rolls
     */
    function changePlayerPosition($playerId, $rollResult){
        $this->modifyCellContent($playerId->currentPosition, $playerId->pawn, 'remove');
        $playerId->currentPosition = Utils::countNextPosition($rollResult, $this->numberOfBoardCells, $playerId->currentPosition); 
        $this->modifyCellContent($playerId->currentPosition, $playerId->pawn, 'insertPlayerPawn');
    }

    /**
     * modifies cell by changing owner and visual appeareance
     * @param int $boardCellId - current cell id
     * @param object $player
     */
    function purchaseCell($boardCellId, $player){
        $cell = $this->board['cells'][$boardCellId];

        $player->countAccountBalance("substract", $cell['purchasePrice']);
        $this->changeCellOwner($player->nick, $boardCellId);
        $this->changeCellBorderColor($boardCellId, $player);
    }

    /**
     * changes cell owner
     * @param int $boardCellId - current cell id
     * @param string $playerNick
     */
    function changeCellOwner($playerNick = 'bank', $boardCellId){
        $this->board['cells'][$boardCellId]['owner'] = $playerNick;
    }

    /**
     * changes cell border color
     * @param int $boardCellId - current cell id
     * @param object $player
     */
    function changeCellBorderColor($boardCellId, $player){
        $this->modifyCellContent($boardCellId, $player->colorHEX, "borderColor");
    }

    /**
     * @param int $boardCellId - current cell id
     * @return string $html - content of cell
     */
    function cellDetailsHTML($boardCellId, $buyingPhase = false, $playerVarName = null, $player = null){
        $cell = $this->board['cells'][$boardCellId];

        $html = '<span class="close" onclick="closePopup();">&times;</span>';
        $html .= "<div>";
            $html .= "<h1>";
            $html .= $cell['name']; //TODO custom name
            $html .= " - ";
            $html .= $cell['owner'];
            $html .= "</h1>";

            $html .= "<h2>";
            $html .= "Purchase price: ";
            $html .= $cell['purchasePrice'];
            if($buyingPhase && $cell['owner'] == "bank" && $cell['owner'] != $playerVarName){
                $disabled = $player->accountBalance < $cell['purchasePrice']? "disabled": "";
                $html .= '$ - <button class="buyingPhase" onclick="buyCellPrompt('.$boardCellId.', \''.$playerVarName.'\', \''.$cell['name'].'\', '.$cell['purchasePrice'].')" '.$disabled.'>Buy</button><br>';
            }
            $html .= "</h2>";

            $html .= "<h2>";
            $html .= "Rent prices:";
            $html .= "</h2>";
            $html .= '<div class="subListPopup">';
            foreach($cell['rentPrices'] as $key=>$price){
                if($key == $cell['houseLevel']){
                    $html .= '<b>';
                    $html .= $key.' => '.$price;
                    $html .= '$</b><br>';
                }
                else
                    $html .= $key.' => '.$price.'$<br>';
            }
            $html .= "</div>";

            $html .= "<h2>";
            $html .= "Housing prices:";
            $html .= "</h2>";
            $html .= '<div class="subListPopup">';
            foreach($cell['housingPrices'] as $key=>$price){
                if($key == $cell['houseLevel']){
                    $html .= '<b>';
                    $html .= $key.' => '.$price;
                    $html .= '$</b>';
                }
                else
                    $html .= $key.' => '.$price.'$';

                if($buyingPhase && $cell['owner'] == $playerVarName && $key > $cell['houseLevel']){
                    $html .= ' - <button onclick="">Buy</button><br>';
                }
                else 
                    $html .= '<br>';
            }
            $html .= "</div>";

        $html .= "</div>";
        return $html;
    }

    /**
     * @param int $numberOfDices - how many dices will be generated
     * @return string $html - dice
     */
    function prepareDiceHTML($numberOfDices){
        $html = "";
        for($i=0;$i<$numberOfDices;$i++){
            $html .= "
            <div class='dice' id='dice_".$i."'>
                <div class='diceOne'>
                    <div class='dot'></div>
                </div>
                <div class='diceTwo'>
                    <div class='dot'></div>
                    <div class='dot'></div>
                </div>
                <div class='diceThree'>
                    <div class='dot'></div>
                    <div class='dot'></div>
                    <div class='dot'></div>
                </div>
                <div class='diceFour'>
                    <div class='column'>
                        <div class='dot'></div>
                        <div class='dot'></div>
                    </div>
                    <div class='column'>
                        <div class='dot'></div>
                        <div class='dot'></div>
                    </div>
                </div>
                <div class='diceFive'>
                    <div class='column'>
                        <div class='dot'></div>
                        <div class='dot'></div>
                    </div>
                    <div class='dot'></div>
                    <div class='column'>
                        <div class='dot'></div>
                        <div class='dot'></div>
                    </div>
                </div>
                <div class='diceSix'>
                    <div class='column'>
                        <div class='dot'></div>
                        <div class='dot'></div>
                        <div class='dot'></div>
                    </div>
                    <div class='column'>
                        <div class='dot'></div>
                        <div class='dot'></div>
                        <div class='dot'></div>
                    </div>
                </div>
            </div>
            ";
        }
        return $html;
    }

    /**
     * Refreshes board['html']
     */
    function refreshBoard(){
        $boardCellId = 0;
        $leftLine = $this->numberOfBoardCells-1;
        $bottomLine = 3*$this->square-3;

        $this->board['html'] = $this->board['table']['startTable'];
        for($i = 0; $i < $this->square; $i++){//tr
            $this->board['html'] .= $this->board['table']['row_'.$i];
            for($j = 0; $j < $this->square; $j++){//td
                if($i == 0 || $i == $this->square-1){//top and boottom
                    if($i == $this->square-1){//bottom
                        $this->board['html'] .= $this->board['cells'][$bottomLine]['html'];
                        $bottomLine--;
                    }
                    else{//top
                        $this->board['html'] .= $this->board['cells'][$boardCellId]['html'];
                        $boardCellId++;
                    }
                }
                elseif($i != 0 && $i != $this->square-1 && ($j == 0 || $j == 1)){//left and right
                    if($j == 0){
                        $this->board['html'] .= $this->board['cells'][$leftLine]['html'];
                        $leftLine--;
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