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
                    'extraRules' => '',
                    'perks' => array()
                );
                $cells[1] = array(
                    'name' => 'Chicken farm',
                    'special' => false,
                    'backgroundIMG' => '',
                    'extraRules' => '',
                    'perks' => array()
                );
                $cells[2] = array(
                    'name' => 'Old windmill',
                    'special' => false,
                    'backgroundIMG' => '',
                    'extraRules' => '',
                    'perks' => array()
                );
                $cells[3] = array(
                    'name' => 'Stables',
                    'special' => false,
                    'backgroundIMG' => '',
                    'extraRules' => '',
                    'perks' => array()
                );
                $cells[4] = array(
                    'name' => 'Monument of greed',
                    'special' => true,
                    'backgroundIMG' => '',
                    'extraRules' => array(
                        'purchasePrice' => '1',
                        'rentPrices' => array(
                            1 => '1',
                            2 => '2',
                            3 => '3',
                            4 => '4',
                        )
                    ),
                    'perks' => array(
                        'getExtraMoneyWhenGoingThroughTavern' => 'owner',
                    )
                );
                $cells[5] = array(
                    'name' => 'Magic wheel',
                    'special' => true,
                    'backgroundIMG' => '',
                    'extraRules' => array(
                    ),
                    'perks' => array(
                        'rotateTheWheel' => 'onenter',
                    )
                );
                $cells[6] = array(
                    'name' => 'Swamps',
                    'special' => false,
                    'backgroundIMG' => '',
                    'extraRules' => '',
                    'perks' => array()
                );
                $cells[7] = array(
                    'name' => 'Witcher\'s hut',
                    'special' => false,
                    'backgroundIMG' => '',
                    'extraRules' => '',
                    'perks' => array()
                );
                $cells[8] = array(
                    'name' => 'Shroomland',
                    'special' => false,
                    'backgroundIMG' => '',
                    'extraRules' => '',
                    'perks' => array()
                );
                $cells[9] = array(
                    'name' => 'Trap',
                    'special' => true,
                    'backgroundIMG' => '',
                    'extraRules' => array(
                    ),
                    'perks' => array(
                        'enforcePlayerToGetOut' => 'activate',
                    )
                );
                $cells[10] = array(
                    'name' => 'Jungle tribe',
                    'special' => false,
                    'backgroundIMG' => '',
                    'extraRules' => '',
                    'perks' => array()
                );
                $cells[11] = array(
                    'name' => 'World tree',
                    'special' => false,
                    'backgroundIMG' => '',
                    'extraRules' => '',
                    'perks' => array()
                );
                $cells[12] = array(
                    'name' => 'Elven house',
                    'special' => false,
                    'backgroundIMG' => '',
                    'extraRules' => '',
                    'perks' => array()
                );
                $cells[13] = array(
                    'name' => 'Monument of stealth',
                    'special' => true,
                    'backgroundIMG' => '',
                    'extraRules' => array(
                        'purchasePrice' => '1',
                        'rentPrices' => array(
                            1 => '1',
                            2 => '2',
                            3 => '3',
                            4 => '4',
                        ),
                    ),
                    'perks' => array(
                        'ignoreRentPaymentOnceEveryLoop' => 'owner',
                        )
                );
                $cells[14] = array(
                    'name' => 'Magic wheel',
                    'special' => true,
                    'backgroundIMG' => '',
                    'extraRules' => array(
                    ),
                    'perks' => array(
                        'rotateTheWheel' => ''
                    )
                );
                $cells[15] = array(
                    'name' => 'Dwarven cavern',
                    'special' => false,
                    'backgroundIMG' => '',
                    'extraRules' => '',
                    'perks' => array()
                );
                $cells[16] = array(
                    'name' => 'Lonely rock',
                    'special' => false,
                    'backgroundIMG' => '',
                    'extraRules' => '',
                    'perks' => array()
                );
                $cells[17] = array(
                    'name' => 'Mine',
                    'special' => false,
                    'backgroundIMG' => '',
                    'extraRules' => '',
                    'perks' => array()
                );
                $cells[18] = array(
                    'name' => 'Sacred altar',
                    'special' => true,
                    'backgroundIMG' => '',
                    'extraRules' => array(
                    ),
                    'perks' => array(
                        'blessChosenCell' => 'active_function'
                    )
                );
                $cells[19] = array(
                    'name' => 'Barracks',
                    'special' => false,
                    'backgroundIMG' => '',
                    'extraRules' => '',
                    'perks' => array()
                );
                $cells[20] = array(
                    'name' => 'Castle',
                    'special' => false,
                    'backgroundIMG' => '',
                    'extraRules' => '',
                    'perks' => array()
                );
                $cells[21] = array(
                    'name' => 'Archery range',
                    'special' => false,
                    'backgroundIMG' => '',
                    'extraRules' => '',
                    'perks' => array()
                );
                $cells[22] = array(
                    'name' => 'Monument of speed',
                    'special' => true,
                    'backgroundIMG' => '',
                    'extraRules' => array(
                        'purchasePrice' => '1',
                        'rentPrices' => array(
                            1 => '1',
                            2 => '2',
                            3 => '3',
                            4 => '4',
                        )
                    ),
                    'perks' => array(
                        'multiplyRollResultEveryLoop' => 'owner',
                    )
                );
                $cells[23] = array(
                    'name' => 'Magic wheel',
                    'special' => true,
                    'backgroundIMG' => '',
                    'extraRules' => array(
                    ),
                    'perks' => array(
                        'rotateTheWheel' => 'onenter'
                    )
                );
                $cells[24] = array(
                    'name' => 'Academy',
                    'special' => false,
                    'backgroundIMG' => '',
                    'extraRules' => '',
                    'perks' => array()
                );
                $cells[25] = array(
                    'name' => 'Magic tower',
                    'special' => false,
                    'backgroundIMG' => '',
                    'extraRules' => '',
                    'perks' => array()
                );
                $cells[26] = array(
                    'name' => 'Spell circle',
                    'special' => false,
                    'backgroundIMG' => '',
                    'extraRules' => '',
                    'perks' => array()
                );
                $cells[27] = array(
                    'name' => 'Secret path',
                    'special' => true,
                    'backgroundIMG' => '',
                    'extraRules' => array(
                    ),
                    'perks' => array(
                        'getSecretPathCard' => 'onenter'
                    )
                );
                $cells[28] = array(
                    'name' => 'Landlord',
                    'special' => true,
                    'backgroundIMG' => '',
                    'extraRules' => array(
                    ),
                    'perks' => array(
                        'getLandlordPerk' => 'owner'
                    )
                );
                $cells[29] = array(
                    'name' => 'Gambling man',
                    'special' => true,
                    'backgroundIMG' => '',
                    'extraRules' => array(
                    ),
                    'perks' => array(
                        'getGamblingPerk' => 'owner'
                    )
                );
                $cells[30] = array(
                    'name' => 'Trapper',
                    'special' => true,
                    'backgroundIMG' => '',
                    'extraRules' => array(
                    ),
                    'perks' => array(
                        'getTrapperPerk' => 'owner'
                    )
                );
                $cells[31] = array(
                    'name' => 'Merchant',
                    'special' => true,
                    'backgroundIMG' => '',
                    'extraRules' => array(
                    ),
                    'perks' => array(
                        'getMerchantPerk' => 'owner'
                    )
                );
                $cells[32] = array(
                    'name' => 'Builder',
                    'special' => true,
                    'backgroundIMG' => '',
                    'extraRules' => array(
                    ),
                    'perks' => array(
                        'getBuilderPerk' => 'owner'
                    )
                );
                $cells[33] = array(
                    'name' => 'Monument of freedom',
                    'special' => true,
                    'backgroundIMG' => '',
                    'extraRules' => array(
                        'purchasePrice' => '1',
                        'rentPrices' => array(
                            1 => '1',
                            2 => '2',
                            3 => '3',
                            4 => '4',
                        )
                    ),
                    'perks' => array(
                        'ignoreNegativeEffectEveryLoop' => 'owner',
                    )
                );
                $cells[34] = array(
                    'name' => 'Demon lord\'s wall',
                    'special' => false,
                    'backgroundIMG' => '',
                    'extraRules' => '',
                    'perks' => array()
                );
                $cells[35] = array(
                    'name' => 'Demon lord\'s realm',
                    'special' => false,
                    'backgroundIMG' => '',
                    'extraRules' => '',
                    'perks' => array()
                );
                return $cells;
        }
        return true;
    }
}