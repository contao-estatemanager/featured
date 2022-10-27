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

use ContaoEstateManager\Featured\AddonManager;

if (AddonManager::valid())
{
    // Extend estate manager statusTokens field options
    $GLOBALS['TL_DCA']['tl_expose_module']['fields']['statusTokens']['options'][] = 'featured';
}
