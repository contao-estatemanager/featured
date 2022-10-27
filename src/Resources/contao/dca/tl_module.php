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

use Contao\CoreBundle\DataContainer\PaletteManipulator;
use ContaoEstateManager\Featured\AddonManager;

if (AddonManager::valid())
{
    // Subpalettes
    $GLOBALS['TL_DCA']['tl_module']['subpalettes']['listMode_featured'] = 'realEstateGroups,filterMode';

    // Extend estate manager listMode field options
    $GLOBALS['TL_DCA']['tl_module']['fields']['listMode']['options'][] = 'featured';

    // Extend estate manager statusTokens field options
    $GLOBALS['TL_DCA']['tl_module']['fields']['statusTokens']['options'][] = 'featured';

    // Fields
    $GLOBALS['TL_DCA']['tl_module']['fields']['prependFeaturedObjects'] = [
        'label' => &$GLOBALS['TL_LANG']['tl_module']['prependFeaturedObjects'],
        'exclude' => true,
        'inputType' => 'checkbox',
        'eval' => ['tl_class' => 'm12 w50'],
        'sql' => "char(1) NOT NULL default '0'",
    ];

    // Extend the default palettes
    PaletteManipulator::create()
        ->addField(['prependFeaturedObjects'], 'listSorting', PaletteManipulator::POSITION_AFTER)
        ->applyToPalette('realEstateList', 'tl_module')
    ;
}
