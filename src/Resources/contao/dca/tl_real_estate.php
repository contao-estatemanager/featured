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

use Contao\Backend;
use Contao\CoreBundle\DataContainer\PaletteManipulator;
use Contao\CoreBundle\Exception\AccessDeniedException;
use Contao\DataContainer;
use Contao\Image;
use Contao\Input;
use Contao\StringUtil;
use Contao\Versions;
use ContaoEstateManager\Featured\AddonManager;

if (AddonManager::valid())
{
    $GLOBALS['TL_DCA']['tl_real_estate']['list']['label']['post_label_callbacks'][] = ['tl_real_estate_featured', 'addFeaturedInformation'];

    // Add operations
    $GLOBALS['TL_DCA']['tl_real_estate']['list']['operations']['featuredObject'] = [
        'label' => &$GLOBALS['TL_LANG']['tl_real_estate']['featuredObject'],
        'icon' => 'featured.svg',
        'attributes' => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleFeaturedObject(this,%s)"',
        'button_callback' => ['tl_real_estate_featured', 'iconFeaturedObject'],
    ];

    // Add field
    $GLOBALS['TL_DCA']['tl_real_estate']['fields']['featuredObject'] = [
        'label' => &$GLOBALS['TL_LANG']['tl_real_estate']['featuredObject'],
        'exclude' => true,
        'filter' => true,
        'inputType' => 'checkbox',
        'eval' => ['tl_class' => 'w50 m12'],
        'sql' => "char(1) NOT NULL default '0'",
    ];

    // Extend the default palettes
    PaletteManipulator::create()
        ->addLegend('featured_object_legend', 'real_estate_media_legend', PaletteManipulator::POSITION_AFTER)
        ->addField(['featuredObject'], 'featured_object_legend', PaletteManipulator::POSITION_APPEND)
        ->applyToPalette('default', 'tl_real_estate')
    ;
}

/**
 * Provide miscellaneous methods that are used by the data configuration array.
 *
 * @author Daniele Sciannimanica <daniele@oveleon.de>
 */
class tl_real_estate_featured extends Backend
{
    /**
     * Import the back end user object.
     */
    public function __construct()
    {
        parent::__construct();
        $this->import('Contao\BackendUser', 'User');
    }

    /**
     * Return the "featured object" button.
     *
     * @param string $href
     */
    public function iconFeaturedObject(array $row, ?string $href, string $label, string $title, string $icon, string $attributes): string
    {
        if (strlen(Input::get('toid') ?? ''))
        {
            $this->toggleFeaturedObject((int) Input::get('toid'), 1 === (int) Input::get('state'), (@func_get_arg(12) ?: null));
            $this->redirect($this->getReferer());
        }

        // Check permissions AFTER checking the fid, so hacking attempts are logged
        if (!$this->User->hasAccess('tl_real_estate::featuredObject', 'alexf'))
        {
            return '';
        }

        $href .= '&amp;toid='.$row['id'].'&amp;state='.($row['featuredObject'] ? '' : 1);

        if (!$row['featuredObject'])
        {
            $icon = 'featured_.svg';
        }

        return '<a href="'.$this->addToUrl($href).'" title="'.StringUtil::specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label, 'data-state="'.($row['featuredObject'] ? 1 : 0).'"').'</a> ';
    }

    /**
     * Toggle top object flag for a real estate.
     *
     * @throws AccessDeniedException
     */
    public function toggleFeaturedObject(int $intId, bool $blnVisible, ?DataContainer $dc = null): void
    {
        // Check permissions to edit
        Input::setGet('id', $intId);
        Input::setGet('act', 'featuredObject');

        // Check permissions to feature
        if (!$this->User->hasAccess('tl_real_estate::featuredObject', 'alexf'))
        {
            throw new AccessDeniedException('Not enough permissions to declare top object flag for item ID '.$intId.'.');
        }

        $objVersions = new Versions('tl_real_estate', $intId);
        $objVersions->initialize();

        // Trigger the save_callback
        if (is_array($GLOBALS['TL_DCA']['tl_real_estate']['fields']['featuredObject']['save_callback'] ?? null))
        {
            foreach ($GLOBALS['TL_DCA']['tl_real_estate']['fields']['featuredObject']['save_callback'] as $callback)
            {
                if (is_array($callback))
                {
                    $this->import($callback[0]);
                    $blnVisible = $this->{$callback[0]}->{$callback[1]}($blnVisible, $dc);
                }
                elseif (is_callable($callback))
                {
                    $blnVisible = $callback($blnVisible, $this);
                }
            }
        }

        // Update the database
        $this->Database->prepare('UPDATE tl_real_estate SET tstamp='.time().", featuredObject='".($blnVisible ? 1 : 0)."' WHERE id=?")
            ->execute($intId)
        ;

        $objVersions->create();
    }

    /**
     * Add featured flag.
     */
    public function addFeaturedInformation(array $row, string $label, DataContainer $dc, array $args): array
    {
        if (!$row['featuredObject'])
        {
            return $args;
        }

        // add reference information
        $args[0] .= '<span class="token" style="background-color:#fff80c;" title="'.$GLOBALS['TL_LANG']['tl_real_estate']['featuredObject'][0].'">F</span>';

        return $args;
    }
}
