<?php
/**
 * This file is part of Oveleon ImmoManager.
 *
 * @link      https://github.com/oveleon/contao-immo-manager-bundle
 * @copyright Copyright (c) 2018-2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://github.com/oveleon/contao-immo-manager-bundle/blob/master/LICENSE
 */

namespace Oveleon\ContaoImmoManagerFeaturedBundle;

use Oveleon\ContaoImmoManagerBundle\Translator;
use Oveleon\ContaoImmoManagerBundle\RealEstateModel;

class Featured
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
    public function countItems(&$intCount, $context)
    {
        if($context->listMode !== 'featured'){
            return;
        }

        $arrColumns = array(
            "$this->strTable.published=1",
            "$this->strTable.featuredObject=1"
        );

        $intCount = RealEstateModel::countBy($arrColumns);
    }

    /**
     * Fetch featured objects
     *
     * @param $objRealEstate
     * @param $limit
     * @param $offset
     * @param $context
     */
    public function fetchItems(&$objRealEstate, $limit, $offset, $context)
    {
        if($context->listMode !== 'featured'){
            return;
        }

        $arrOptions = array(
            'limit' => $limit,
            'offset' => $offset
        );

        $arrColumns = array(
            "$this->strTable.published=1",
            "$this->strTable.featuredObject=1"
        );

        $objRealEstate = RealEstateModel::findBy($arrColumns, null, $arrOptions);
    }


    /**
     * Add status token for featured objects
     *
     * @param $objTemplate
     * @param $realEstate
     * @param $context
     */
    public function addStatusToken(&$objTemplate, $realEstate, $context)
    {
        $tokens = \StringUtil::deserialize($context->statusTokens);

        if(!$tokens){
            return;
        }
        
        if (in_array('featured', $tokens) && $realEstate->objRealEstate->featuredObject)
        {
            $objTemplate->arrStatusTokens = array_merge(
                $objTemplate->arrStatusTokens,
                array
                (
                    array(
                        'value' => Translator::translateValue('featuredObject'),
                        'class' => 'featured'
                    )
                )
            );

            $context->isEmpty = !count($objTemplate->arrStatusTokens);
        }
    }
}