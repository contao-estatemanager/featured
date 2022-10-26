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
use ContaoEstateManager\Featured\FeaturedObjects;

if (AddonManager::valid())
{
    // Hooks
    $GLOBALS['TL_HOOKS']['countItemsRealEstateList'][] = [FeaturedObjects::class, 'countItems'];
    $GLOBALS['TL_HOOKS']['fetchItemsRealEstateList'][] = [FeaturedObjects::class, 'fetchItems'];
    $GLOBALS['TL_HOOKS']['getStatusTokens'][] = [FeaturedObjects::class, 'addStatusToken'];
}
