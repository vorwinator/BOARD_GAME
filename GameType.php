<?php
/**
 * @author Roman Mohyła
 */
class GameType extends MainController{

    function prepareGameType(){
        switch($this->gameType[0]){
            case 'standard':
                $cells[0] = array(
                    'name' => 'Tavern',
                    'special' => true,
                    'backgroundIMG' => '',
                    'extraRules' => ''
                );
                $cells[1] = array(
                    'name' => 'Chicken farm',
                    'special' => false,
                    'backgroundIMG' => '',
                    'extraRules' => ''
                );
                $cells[2] = array(
                    'name' => 'Old windmill',
                    'special' => false,
                    'backgroundIMG' => '',
                    'extraRules' => ''
                );
                $cells[3] = array(
                    'name' => 'Stables',
                    'special' => false,
                    'backgroundIMG' => '',
                    'extraRules' => ''
                );
                $cells[4] = array(
                    'name' => 'Monument of greed',
                    'special' => true,
                    'backgroundIMG' => '',
                    'extraRules' => array(
                        'purchasePrice' => '',
                        'getExtraMoneyWhenGoingThroughTavern' => '',
                        'rentPrices' => ''
                    )
                );
                $cells[5] = array(
                    'name' => 'Magic wheel',
                    'special' => true,
                    'backgroundIMG' => '',
                    'extraRules' => array(
                        'rotateTheWheel' => ''
                    )
                );
                $cells[6] = array(
                    'name' => 'Swamps',
                    'special' => false,
                    'backgroundIMG' => '',
                    'extraRules' => ''
                );
                $cells[7] = array(
                    'name' => 'Witcher\'s hut',
                    'special' => false,
                    'backgroundIMG' => '',
                    'extraRules' => ''
                );
                $cells[8] = array(
                    'name' => 'Shroomland',
                    'special' => false,
                    'backgroundIMG' => '',
                    'extraRules' => ''
                );
                $cells[9] = array(
                    'name' => 'Trap',
                    'special' => true,
                    'backgroundIMG' => '',
                    'extraRules' => array(
                        'enforcePlayerToGetOut' => ''
                    )
                );
                $cells[10] = array(
                    'name' => 'Jungle tribe',
                    'special' => false,
                    'backgroundIMG' => '',
                    'extraRules' => ''
                );
                $cells[11] = array(
                    'name' => 'World tree',
                    'special' => false,
                    'backgroundIMG' => '',
                    'extraRules' => ''
                );
                $cells[12] = array(
                    'name' => 'Elven house',
                    'special' => false,
                    'backgroundIMG' => '',
                    'extraRules' => ''
                );
                $cells[13] = array(
                    'name' => 'Monument of stealth',
                    'special' => true,
                    'backgroundIMG' => '',
                    'extraRules' => array(
                        'ignoreRentPaymentOnceEveryLoop' => ''
                    )
                );
                $cells[14] = array(
                    'name' => 'Magic wheel',
                    'special' => true,
                    'backgroundIMG' => '',
                    'extraRules' => array(
                        'rotateTheWheel' => ''
                    )
                );
                $cells[15] = array(
                    'name' => 'Dwarven cavern',
                    'special' => false,
                    'backgroundIMG' => '',
                    'extraRules' => ''
                );
                $cells[16] = array(
                    'name' => 'Lonely rock',
                    'special' => false,
                    'backgroundIMG' => '',
                    'extraRules' => ''
                );
                $cells[17] = array(
                    'name' => 'Mine',
                    'special' => false,
                    'backgroundIMG' => '',
                    'extraRules' => ''
                );
                $cells[18] = array(
                    'name' => 'Sacred altar',
                    'special' => true,
                    'backgroundIMG' => '',
                    'extraRules' => array(
                        'blessChosenCell' => ''
                    )
                );
                $cells[19] = array(
                    'name' => 'Barracks',
                    'special' => false,
                    'backgroundIMG' => '',
                    'extraRules' => '',
                );
                $cells[20] = array(
                    'name' => 'Castle',
                    'special' => false,
                    'backgroundIMG' => '',
                    'extraRules' => '',
                );
                $cells[21] = array(
                    'name' => 'Archery range',
                    'special' => false,
                    'backgroundIMG' => '',
                    'extraRules' => '',
                );
                $cells[22] = array(
                    'name' => 'Monument of speed',
                    'special' => true,
                    'backgroundIMG' => '',
                    'extraRules' => array(
                        'multiplyRollResultEveryLoop' => ''
                    ),
                );
                $cells[23] = array(
                    'name' => 'Magic wheel',
                    'special' => true,
                    'backgroundIMG' => '',
                    'extraRules' => array(
                        'rotateTheWheel' => ''
                    )
                );
                $cells[24] = array(
                    'name' => 'Academy',
                    'special' => false,
                    'backgroundIMG' => '',
                    'extraRules' => '',
                );
                $cells[25] = array(
                    'name' => 'Magic tower',
                    'special' => false,
                    'backgroundIMG' => '',
                    'extraRules' => '',
                );
                $cells[26] = array(
                    'name' => 'Spell circle',
                    'special' => false,
                    'backgroundIMG' => '',
                    'extraRules' => '',
                );
                $cells[27] = array(
                    'name' => 'Secret path',
                    'special' => true,
                    'backgroundIMG' => '',
                    'extraRules' => array(
                        'getSecretPathCard' => ''
                    )
                );
                $cells[28] = array(
                    'name' => 'Landlord',
                    'special' => true,
                    'backgroundIMG' => '',
                    'extraRules' => array(
                        'getLandlordPerk' => ''
                    )
                );
                $cells[29] = array(
                    'name' => 'Gambling man',
                    'special' => true,
                    'backgroundIMG' => '',
                    'extraRules' => array(
                        'getGamblingPerk' => ''
                    )
                );
                $cells[30] = array(
                    'name' => 'Trapper',
                    'special' => true,
                    'backgroundIMG' => '',
                    'extraRules' => array(
                        'getTrapperPerk' => ''
                    )
                );
                $cells[31] = array(
                    'name' => 'Merchant',
                    'special' => true,
                    'backgroundIMG' => '',
                    'extraRules' => array(
                        'getMerchantPerk' => ''
                    )
                );
                $cells[32] = array(
                    'name' => 'Builder',
                    'special' => true,
                    'backgroundIMG' => '',
                    'extraRules' => array(
                        'getBuilderPerk' => ''
                    )
                );
                $cells[33] = array(
                    'name' => 'Monument of freedom',
                    'special' => true,
                    'backgroundIMG' => '',
                    'extraRules' => array(
                        'ignoreNegativeEffectEveryLoop' => ''
                    )
                );
                $cells[34] = array(
                    'name' => 'Demon lord\'s wall',
                    'special' => false,
                    'backgroundIMG' => '',
                    'extraRules' => '',
                );
                $cells[35] = array(
                    'name' => 'Demon lord\'s realm',
                    'special' => false,
                    'backgroundIMG' => '',
                    'extraRules' => '',
                );
                return $cells;
        }
        return true;
    }
}