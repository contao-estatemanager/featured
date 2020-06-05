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
    $GLOBALS['TL_DCA']['tl_module']['fields']['listMode']['options'][] = 'featured';

    // Extend estate manager statusTokens field options
    $GLOBALS['TL_DCA']['tl_module']['fields']['statusTokens']['options'][] = 'featured';

    // Fields
    $GLOBALS['TL_DCA']['tl_module']['fields']['prependFeaturedObjects'] = array
    (
        'label'                     => &$GLOBALS['TL_LANG']['tl_module']['prependFeaturedObjects'],
        'exclude'                   => true,
        'inputType'                 => 'checkbox',
        'eval'                      => array('tl_class' => 'm12 w50'),
        'sql'                       => "char(1) NOT NULL default '0'",
    );

    // Extend the default palettes
    Contao\CoreBundle\DataContainer\PaletteManipulator::create()
        ->addField(array('prependFeaturedObjects'), 'listSorting', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_AFTER)
        ->applyToPalette('realEstateList', 'tl_module')
    ;
}
