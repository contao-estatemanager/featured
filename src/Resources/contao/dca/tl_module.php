<?php
/**
 * This file is part of Contao EstateManager.
 *
 * @link      https://www.contao-estatemanager.com/
 * @source    https://github.com/contao-estatemanager/featured
 * @copyright Copyright (c) 2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://www.contao-estatemanager.com/lizenzbedingungen.html
 */
if(ContaoEstateManager\Featured\AddonManager::valid()) {
    // Subpalettes
    $GLOBALS['TL_DCA']['tl_module']['subpalettes']['listMode_featured'] = 'realEstateGroups,filterMode';

    // Extend estate manager listMode field options
    array_insert($GLOBALS['TL_DCA']['tl_module']['fields']['listMode']['options'], -1, array('featured'));

    // Extend estate manager statusTokens field options
    array_insert($GLOBALS['TL_DCA']['tl_module']['fields']['statusTokens']['options'], -1, array('featured'));
}