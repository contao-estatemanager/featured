<?php
/**
 * This file is part of Oveleon ImmoManager.
 *
 * @link      https://github.com/oveleon/contao-immo-manager-bundle
 * @copyright Copyright (c) 2018-2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://github.com/oveleon/contao-immo-manager-bundle/blob/master/LICENSE
 */

namespace Oveleon\ContaoImmoManagerFeaturedBundle;

use Oveleon\ContaoImmoManagerBundle\ImmoManager;

class AddonManager
{
    /**
     * Addon name
     * @var string
     */
    public static $name = 'Featured';

    /**
     * Addon config key
     * @var string
     */
    public static $key  = 'addon_featured_license';

    /**
     * Is initialized
     * @var boolean
     */
    public static $initialized  = false;

    /**
     * Is valid
     * @var boolean
     */
    public static $valid  = false;

    /**
     * Licenses
     * @var array
     */
    private static $licenses = [
        '6294e245f2b013af2b2f1731c5112e96',
        '7ac33550f1a9342a68a6c03c8f7dd030',
        'ac5feb4d71fd226a5f1ef5f3b3dbec27',
        '1420ed84e1867ba46d93f2ded9d2b2d0',
        '797bc1dfca9e016c69ee5a99112ca484',
        '72b9e2e14355964353d4d64759ce56e5',
        '5dbee22eca0598febfa4c67334fde4b2',
        '49f3d308fb5d48ff59d64d19557f97e6',
        '137ed3e36229a737acbef4dff4a47da8',
        'efb3e36d252c8fc7d34cb77e8fdb7fa5',
        '913bccfcd2ed66b0440db39ed5f5388f',
        'e47dc837ef0e0bfc54222c69a82f74f5',
        'b080aabe0fa8b199c167e88f12ad182c',
        '437f809696266d4b23789a31e3e82001',
        'b83b575f70ba9ec5edae569effde83f7',
        '2600094d4e3add4af8ad6b88f0277d7c',
        'c8eea23a9a9eccab105715a79f4cc3c2',
        '18962430faff4c3659671e4d2f5535c1',
        '8f1b521106fdfe908dc22b6eb57a1988',
        '20e3c774dd6b0cdcf6ca40fe132557a0',
        'f0df7df9af311a2fc7e32a5613a00e87',
        '2de3834c01cb74f303235d2b8764b596',
        'de946780cc700b93e331531d14027fc9',
        '63069fa549d6c972cccc47f1d245d86e',
        '3d311cf3e8edf8b88d8f704a59bad1f9',
        'aec581526a3f91092c5005ef5eb82c74',
        '217a7989c234617d6e734687ef1569ea',
        'e7d540ac27215c1e8786b77b9369b3d8',
        '1e37012f6c5eb6352317a6bb083adb3c',
        '749bfa7f9b816221f902777e39da8c9a',
        'efe31c5c264a871ba2bccc2b4f1d9599',
        '0cd297f358800e6e773644e56177655f',
        '8b01f66039fa639c176d5b8e2c2ebeb3',
        '6037341184b57382a370fd5e3b30f4b5',
        'c289a3b9a59959b621eec74543f8463f',
        '09bcca709e8369e23cf9f72ec36413da',
        'e65975ccc22b13591319c985bb7d1f54',
        '7015b06ffe27bbd58105e8e7650bf327',
        '18f45542f3e4ea39ec07dbac01e4fb9e',
        'fc76ce70aea169cdc45bf4c27a41150b',
        'd3e99a223cfd418fc64a9edd3ad96343',
        'fbfb1e420deaa01c60ed1ffd867d3327',
        '234135a61ee497812a99164fed573ee1',
        'fdb14d45e341047bf4a7e4a6d765b9b6',
        '2f394f7719c0993d3019d9f69ced0e3c',
        '6fd83d9a115f1bdc234a01b178fdd1e3',
        '60579497ff54a1b89c4b0a5fafbc1c05',
        '5b34df82e272f35da661ce1a4399a3f9',
        'c133c25acbefe53ef1c1b38ce3f84ced',
        '48cb1bf25a071a5020a5a46d49b7a09e'
    ];

    public static function getLicenses()
    {
        return static::$licenses;
    }

    public static function valid()
    {
        if(\Environment::get('requestUri') === '/contao/install')
        {
            return true;
        }

        if (static::$initialized === false)
        {
            static::$valid = ImmoManager::checkLicenses(\Config::get(static::$key), static::$licenses, static::$key);
            static::$initialized = true;
        }

        return static::$valid;
    }

}