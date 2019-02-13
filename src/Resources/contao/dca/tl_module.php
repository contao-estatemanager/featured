<?php
/**
 * This file is part of Oveleon ImmoManager.
 *
 * @link      https://github.com/oveleon/contao-immo-manager-bundle
 * @copyright Copyright (c) 2018-2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://github.com/oveleon/contao-immo-manager-bundle/blob/master/LICENSE
 */

// Extend immo manager listMode field options
array_insert($GLOBALS['TL_DCA']['tl_module']['fields']['listMode']['options'], -1, array('featured'));

// Extend immo manager statusTokens field options
array_insert($GLOBALS['TL_DCA']['tl_module']['fields']['statusTokens']['options'], -1, array('featured'));