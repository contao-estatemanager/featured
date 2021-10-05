<?php

declare(strict_types=1);

/*
 * This file is part of Contao EstateManager.
 *
 * @see        https://www.contao-estatemanager.com/
 * @source     https://github.com/contao-estatemanager/featured
 * @copyright  Copyright (c) 2021 Oveleon GbR (https://www.oveleon.de)
 * @license    https://www.contao-estatemanager.com/lizenzbedingungen.html
 */

// ESTATEMANAGER
$GLOBALS['TL_ESTATEMANAGER_ADDONS'][] = ['ContaoEstateManager\Featured', 'AddonManager'];

use ContaoEstateManager\Featured\AddonManager;

if (AddonManager::valid())
{
    // Hooks
    $GLOBALS['TL_HOOKS']['countItemsRealEstateList'][] = ['ContaoEstateManager\Featured\FeaturedObjects', 'countItems'];
    $GLOBALS['TL_HOOKS']['fetchItemsRealEstateList'][] = ['ContaoEstateManager\Featured\FeaturedObjects', 'fetchItems'];

    $GLOBALS['TL_HOOKS']['getStatusTokens'][] = ['ContaoEstateManager\Featured\FeaturedObjects', 'addStatusToken'];
}
