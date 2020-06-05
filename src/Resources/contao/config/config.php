<?php
/**
 * This file is part of Contao EstateManager.
 *
 * @link      https://www.contao-estatemanager.com/
 * @source    https://github.com/contao-estatemanager/featured
 * @copyright Copyright (c) 2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://www.contao-estatemanager.com/lizenzbedingungen.html
 */

// ESTATEMANAGER
$GLOBALS['TL_ESTATEMANAGER_ADDONS'][] = array('ContaoEstateManager\\Featured', 'AddonManager');

if(ContaoEstateManager\Featured\AddonManager::valid()){
    // Hooks
    $GLOBALS['TL_HOOKS']['countItemsRealEstateList'][] = array('ContaoEstateManager\\Featured\\FeaturedObjects', 'countItems');
    $GLOBALS['TL_HOOKS']['fetchItemsRealEstateList'][] = array('ContaoEstateManager\\Featured\\FeaturedObjects', 'fetchItems');

    $GLOBALS['TL_HOOKS']['getStatusTokens'][] = array('ContaoEstateManager\\Featured\\FeaturedObjects', 'addStatusToken');
}
