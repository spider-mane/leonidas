<?php

/**
 * @package Leonidas-Core
 */

namespace WebTheory\GuctilityBelt\SelectOptions;

class UsStatesAndTerritories
{
    private const STATES = [
        'AL' => 'Alabama',
        'AK' => 'Alaska',
        'AZ' => 'Arizona',
        'AR' => 'Arkansas',
        'CA' => 'California',
        'CO' => 'Colorado',
        'CT' => 'Connecticut',
        'DE' => 'Delaware',
        'DC' => 'District of Columbia',
        'FL' => 'Florida',
        'GA' => 'Georgia',
        'HI' => 'Hawaii',
        'ID' => 'Idaho',
        'IL' => 'Illinois',
        'IN' => 'Indiana',
        'IA' => 'Iowa',
        'KS' => 'Kansas',
        'KY' => 'Kentucky',
        'LA' => 'Louisiana',
        'ME' => 'Maine',
        'MD' => 'Maryland',
        'MA' => 'Massachusetts',
        'MI' => 'Michigan',
        'MN' => 'Minnesota',
        'MS' => 'Mississippi',
        'MO' => 'Missouri',
        'MT' => 'Montana',
        'NE' => 'Nebraska',
        'NV' => 'Nevada',
        'NH' => 'New Hampshire',
        'NJ' => 'New Jersey',
        'NM' => 'New Mexico',
        'NY' => 'New York',
        'NC' => 'North Carolina',
        'ND' => 'North Dakota',
        'OH' => 'Ohio',
        'OK' => 'Oklahoma',
        'OR' => 'Oregon',
        'PA' => 'Pennsylvania',
        'RI' => 'Rhode Island',
        'SC' => 'South Carolina',
        'SD' => 'South Dakota',
        'TN' => 'Tennessee',
        'TX' => 'Texas',
        'UT' => 'Utah',
        'VT' => 'Vermont',
        'VA' => 'Virginia',
        'WA' => 'Washington',
        'WV' => 'West Virginia',
        'WI' => 'Wisconsin',
        'WY' => 'Wyoming',
    ];

    /**
     *
     */
    private const TERRITORIES = [
        "AS" => "American Samoa",
        "GU" => "Guam",
        "MP" => "Northern Mariana Islands",
        "PR" => "Puerto Rico",
        "UM" => "United States Minor Outlying Islands",
        "VI" => "Virgin Islands",
    ];

    /**
     *
     */
    private const ARMEDFORCES = [
        "AA" => "Armed Forces Americas",
        "AP" => "Armed Forces Pacific",
        "AE" => "Armed Forces Other",
    ];

    /**
     *
     */
    public static function states(?string $placeholder = null)
    {
        $states = static::STATES;

        if (isset($placeholder)) {
            $states = ['' => $placeholder] + $states;
        }

        return $states;
    }

    /**
     *
     */
    public static function territories()
    {
        return static::TERRITORIES;
    }

    /**
     *
     */
    public static function armedForces()
    {
        return static::ARMEDFORCES;
    }
}
