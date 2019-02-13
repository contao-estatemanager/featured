<?php
/**
 * This file is part of Oveleon ImmoManager.
 *
 * @link      https://github.com/oveleon/contao-immo-manager-bundle
 * @copyright Copyright (c) 2018-2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://github.com/oveleon/contao-immo-manager-bundle/blob/master/LICENSE
 */

// IMMOMANAGER
$GLOBALS['TL_IMMOMANAGER_ADDONS'][] = array('Oveleon\\ContaoImmoManagerFeaturedBundle', 'AddonManager');

// HOOKS
$GLOBALS['TL_HOOKS']['realEstateListCountItems'][] = array('Oveleon\\ContaoImmoManagerFeaturedBundle\\Featured', 'countItems');
$GLOBALS['TL_HOOKS']['realEstateListFetchItems'][] = array('Oveleon\\ContaoImmoManagerFeaturedBundle\\Featured', 'fetchItems');
$GLOBALS['TL_HOOKS']['parseRealEstate'][] = array('Oveleon\\ContaoImmoManagerFeaturedBundle\\Featured', 'addStatusToken');