<?php
/**
 * This file is part of Oveleon ImmoManager.
 *
 * @link      https://github.com/oveleon/contao-immo-manager-bundle
 * @copyright Copyright (c) 2018-2019  Oveleon GbR (https://www.oveleon.de)
 * @license   https://github.com/oveleon/contao-immo-manager-bundle/blob/master/LICENSE
 */

namespace Oveleon\ContaoImmoManagerFeaturedBundle;


class AddonManager
{
    public static $name = 'Featured';

    private static $licenses = [
        'e720a07a8060441abbc7f491d21531c6',
        '35db9865adc10164750febbb2157079f',
        'a7349004323566a1b7dadd22bb94b304',
        'b075a50b12b01336ac0d3121c63bd9bd',
        '6afbedb18f56e43f5d31d0676318fc17',
        'f7fa1348417fef2c287a938f829e6046',
        'd36296125885d97a7be46319dd8a02bc',
        'b37d0d305e44fbdb62c3a752c84338c1',
        'c4e5f78ab948543ea481d58365375987',
        'e290a29c5f2741387818250936ba4b78',
        '0407aeb524b5ba800b1a4e2263e26632',
        '86756004024c64a97f4e14156f41143b',
        '78985279bf6c5fdb7c288a3bb332eb47',
        'a33937c1b01978efb0afc967409d6081',
        '84d55d5e6d55128f753b80ee7587b7c5'
    ];

    public static function getLicenses()
    {
        return static::$licenses;
    }
}