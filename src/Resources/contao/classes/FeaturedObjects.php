<?php
/**
 * This file is part of Contao EstateManager.
 *
 * @link      https://www.contao-estatemanager.com/
 * @source    https://github.com/contao-estatemanager/featured
 * @copyright Copyright (c) 2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://www.contao-estatemanager.com/lizenzbedingungen.html
 */

namespace ContaoEstateManager\Featured;

use Contao\StringUtil;
use ContaoEstateManager\FilterSession;
use ContaoEstateManager\Translator;
use ContaoEstateManager\RealEstateModel;

class FeaturedObjects
{
    /**
     * Table
     * @var string
     */
    protected $strTable = 'tl_real_estate';

    /**
     * Count featured objects
     *
     * @param $intCount
     * @param $context
     */
    public function countItems(&$intCount, $context): void
    {
        if($context->listMode !== 'featured'){
            return;
        }

        $objFilterSession = FilterSession::getInstance();

        list($arrColumns, $arrValues, $arrOptions) = $objFilterSession->getTypeParameterByGroups($context->realEstateGroups, $context->filterMode, false, $context);

        $arrColumns[] = "$this->strTable.featuredObject=1";

        $intCount = RealEstateModel::countPublishedBy($arrColumns, $arrValues);
    }

    /**
     * Fetch featured objects
     *
     * @param $objRealEstate
     * @param $arrOptions
     * @param $context
     */
    public function fetchItems(&$objRealEstate, &$arrOptions, $context): void
    {
        if ($context->prependFeaturedObjects)
        {
            $arrOptions['order'] = "tl_real_estate.featuredObject DESC" . ($arrOptions['order'] ? ', ' . $arrOptions['order'] : '');
        }

        if($context->listMode !== 'featured'){
            return;
        }

        $objFilterSession = FilterSession::getInstance();

        list($arrColumns, $arrValues, $options) = $objFilterSession->getTypeParameterByGroups($context->realEstateGroups, $context->filterMode, false, $context);

        $arrOptions = array_merge($options, $arrOptions);

        $arrColumns[] = "$this->strTable.featuredObject=1";

        $objRealEstate = RealEstateModel::findPublishedBy($arrColumns, $arrValues, $arrOptions);
    }


    /**
     * Add status token for featured objects
     *
     * @param $validStatusToken
     * @param $arrStatusTokens
     * @param $context
     */
    public function addStatusToken($validStatusToken, &$arrStatusTokens, $context): void
    {
        if (in_array('featured', $validStatusToken) && $context->objRealEstate->featuredObject)
        {
            $arrStatusTokens[] = array(
                'value' => Translator::translateValue('featuredObject'),
                'class' => 'featured'
            );
        }
    }
}
