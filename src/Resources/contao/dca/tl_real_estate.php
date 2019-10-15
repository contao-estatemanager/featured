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
    // Add operations
    array_insert($GLOBALS['TL_DCA']['tl_real_estate']['list']['operations'], -1, array(
        'featuredObject' => array
        (
            'label'               => &$GLOBALS['TL_LANG']['tl_real_estate']['featuredObject'],
            'icon'                => 'featured.svg',
            'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleFeaturedObject(this,%s)"',
            'button_callback'     => array('tl_real_estate_featured', 'iconFeaturedObject')
        )
    ));

    // Add field
    array_insert($GLOBALS['TL_DCA']['tl_real_estate']['fields'], -1, array(
        'featuredObject'  => array
        (
            'label'                     => &$GLOBALS['TL_LANG']['tl_real_estate']['featuredObject'],
            'filter'                    => true,
            'inputType'                 => 'checkbox',
            'eval'                      => array('tl_class' => 'w50 m12'),
            'sql'                       => "char(1) NOT NULL default '0'",
        )
    ));

    // Extend the default palettes
    Contao\CoreBundle\DataContainer\PaletteManipulator::create()
        ->addLegend('featured_object_legend', 'real_estate_media_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_AFTER)
        ->addField(array('featuredObject'), 'featured_object_legend', Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND)
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
     * Import the back end user object
     */
    public function __construct()
    {
        parent::__construct();
        $this->import('BackendUser', 'User');
    }

    /**
     * Check permissions to edit table tl_real_estate
     */
    public function checkPermission()
    {
        return;
    }

    /**
     * Return the "featured object" button
     *
     * @param array  $row
     * @param string $href
     * @param string $label
     * @param string $title
     * @param string $icon
     * @param string $attributes
     *
     * @return string
     */
    public function iconFeaturedObject($row, $href, $label, $title, $icon, $attributes)
    {
        if (\strlen(Input::get('toid')))
        {
            $this->toggleFeaturedObject(Input::get('toid'), (Input::get('state') == 1), (@func_get_arg(12) ?: null));
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

        return '<a href="'.$this->addToUrl($href).'" title="'.StringUtil::specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label, 'data-state="' . ($row['featuredObject'] ? 1 : 0) . '"').'</a> ';
    }

    /**
     * Toggle top object flag for a real estate
     *
     * @param integer       $intId
     * @param boolean       $blnVisible
     * @param DataContainer $dc
     *
     * @throws Contao\CoreBundle\Exception\AccessDeniedException
     */
    public function toggleFeaturedObject($intId, $blnVisible, DataContainer $dc=null)
    {
        // Check permissions to edit
        Input::setGet('id', $intId);
        Input::setGet('act', 'featuredObject');
        $this->checkPermission();

        // Check permissions to feature
        if (!$this->User->hasAccess('tl_real_estate::featuredObject', 'alexf'))
        {
            throw new Contao\CoreBundle\Exception\AccessDeniedException('Not enough permissions to declare top object flag for item ID ' . $intId . '.');
        }

        $objVersions = new Versions('tl_real_estate', $intId);
        $objVersions->initialize();

        // Trigger the save_callback
        if (\is_array($GLOBALS['TL_DCA']['tl_real_estate']['fields']['featuredObject']['save_callback']))
        {
            foreach ($GLOBALS['TL_DCA']['tl_real_estate']['fields']['featuredObject']['save_callback'] as $callback)
            {
                if (\is_array($callback))
                {
                    $this->import($callback[0]);
                    $blnVisible = $this->{$callback[0]}->{$callback[1]}($blnVisible, $dc);
                }
                elseif (\is_callable($callback))
                {
                    $blnVisible = $callback($blnVisible, $this);
                }
            }
        }

        // Update the database
        $this->Database->prepare("UPDATE tl_real_estate SET tstamp=". time() .", featuredObject='" . ($blnVisible ? 1 : '') . "' WHERE id=?")
            ->execute($intId);

        $objVersions->create();
    }
}