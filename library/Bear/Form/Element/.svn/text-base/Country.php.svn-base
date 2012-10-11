<?php
/**
 * Bear
 *
 * @category Bear
 * @package Bear_Form
 */

/** Bear_Form_Element_Select */
require_once 'Bear/Form/Element/Select.php';

/**
 * country form element
 *
 * @category Bear
 * @package Bear_Form
 * @author Konr Ness <konr.ness@nerdery.com>
 * @author Ali Abu El Haj <aaelhaj@nerdery.com>
 */
class Bear_Form_Element_Country extends Bear_Form_Element_Select
{

    /**
     * Dummy text
     *
     * @var string
     */
    protected $_dummyText = "Choose...";

    /**
     * Should abbreviated country name values be returned?
     *
     * @var boolean
     */
    protected $_returnAbbreviatedCountryValues = false;

    /**
     * Countries
     *
     * @var array
     */
    protected $_countries = array(
        'ad' => 'Andorra',
        'ae' => 'United Arab Emirates',
        'af' => 'Afghanistan',
        'ag' => 'Antigua and Barbuda',
        'ai' => 'Anguilla',
        'al' => 'Albania',
        'am' => 'Armenia',
        'an' => 'Netherlands Antilles',
        'ao' => 'Angola',
        'aq' => 'Antarctica',
        'ar' => 'Argentina',
        'as' => 'American Samoa',
        'at' => 'Austria',
        'au' => 'Australia',
        'aw' => 'Aruba',
        'az' => 'Azerbaijan',
        'ba' => 'Bosnia Hercegovina',
        'bb' => 'Barbados',
        'bd' => 'Bangladesh',
        'be' => 'Belgium',
        'bf' => 'Burkina Faso',
        'bg' => 'Bulgaria',
        'bh' => 'Bahrain',
        'bi' => 'Burundi',
        'bj' => 'Benin',
        'bm' => 'Bermuda',
        'bn' => 'Brunei Darussalam',
        'bo' => 'Bolivia',
        'br' => 'Brazil',
        'bs' => 'Bahamas',
        'bt' => 'Bhutan',
        'bv' => 'Bouvet Island',
        'bw' => 'Botswana',
        'by' => 'Belarus (Byelorussia)',
        'bz' => 'Belize',
        'ca' => 'Canada',
        'cc' => 'Cocos Islands',
        'cd' => 'Congo, The Democratic Republic of the',
        'cf' => 'Central African Republic',
        'cg' => 'Congo',
        'ch' => 'Switzerland',
        'ci' => 'Ivory Coast',
        'ck' => 'Cook Islands',
        'cl' => 'Chile',
        'cm' => 'Cameroon',
        'cn' => 'China',
        'co' => 'Colombia',
        'cr' => 'Costa Rica',
        'cs' => 'Czechoslovakia',
        'cu' => 'Cuba',
        'cv' => 'Cape Verde',
        'cx' => 'Christmas Island',
        'cy' => 'Cyprus',
        'cz' => 'Czech Republic',
        'de' => 'Germany',
        'dj' => 'Djibouti',
        'dk' => 'Denmark',
        'dm' => 'Dominica',
        'do' => 'Dominican Republic',
        'dz' => 'Algeria',
        'ec' => 'Ecuador',
        'ee' => 'Estonia',
        'eg' => 'Egypt',
        'eh' => 'Western Sahara',
        'er' => 'Eritrea',
        'es' => 'Spain',
        'et' => 'Ethiopia',
        'fi' => 'Finland',
        'fj' => 'Fiji',
        'fk' => 'Falkland Islands',
        'fm' => 'Micronesia',
        'fo' => 'Faroe Islands',
        'fr' => 'France',
        'fx' => 'France, Metropolitan FX',
        'ga' => 'Gabon',
        'gb' => 'United Kingdom (Great Britain)',
        'gd' => 'Grenada',
        'ge' => 'Georgia',
        'gf' => 'French Guiana',
        'gh' => 'Ghana',
        'gi' => 'Gibraltar',
        'gl' => 'Greenland',
        'gm' => 'Gambia',
        'gn' => 'Guinea',
        'gp' => 'Guadeloupe',
        'gq' => 'Equatorial Guinea',
        'gr' => 'Greece',
        'gs' => 'South Georgia and the South Sandwich Islands',
        'gt' => 'Guatemala',
        'gu' => 'Guam',
        'gw' => 'Guinea-bissau',
        'gy' => 'Guyana',
        'hk' => 'Hong Kong',
        'hm' => 'Heard and McDonald Islands',
        'hn' => 'Honduras',
        'hr' => 'Croatia',
        'ht' => 'Haiti',
        'hu' => 'Hungary',
        'id' => 'Indonesia',
        'ie' => 'Ireland',
        'il' => 'Israel',
        'in' => 'India',
        'io' => 'British Indian Ocean Territory',
        'iq' => 'Iraq',
        'ir' => 'Iran',
        'is' => 'Iceland',
        'it' => 'Italy',
        'jm' => 'Jamaica',
        'jo' => 'Jordan',
        'jp' => 'Japan',
        'ke' => 'Kenya',
        'kg' => 'Kyrgyzstan',
        'kh' => 'Cambodia',
        'ki' => 'Kiribati',
        'km' => 'Comoros',
        'kn' => 'Saint Kitts and Nevis',
        'kp' => 'North Korea',
        'kr' => 'South Korea',
        'kw' => 'Kuwait',
        'ky' => 'Cayman Islands',
        'kz' => 'Kazakhstan',
        'la' => 'Laos',
        'lb' => 'Lebanon',
        'lc' => 'Saint Lucia',
        'li' => 'Lichtenstein',
        'lk' => 'Sri Lanka',
        'lr' => 'Liberia',
        'ls' => 'Lesotho',
        'lt' => 'Lithuania',
        'lu' => 'Luxembourg',
        'lv' => 'Latvia',
        'ly' => 'Libya',
        'ma' => 'Morocco',
        'mc' => 'Monaco',
        'md' => 'Moldova Republic',
        'mg' => 'Madagascar',
        'mh' => 'Marshall Islands',
        'mk' => 'Macedonia, The Former Yugoslav Republic of',
        'ml' => 'Mali',
        'mm' => 'Myanmar',
        'mn' => 'Mongolia',
        'mo' => 'Macau',
        'mp' => 'Northern Mariana Islands',
        'mq' => 'Martinique',
        'mr' => 'Mauritania',
        'ms' => 'Montserrat',
        'mt' => 'Malta',
        'mu' => 'Mauritius',
        'mv' => 'Maldives',
        'mw' => 'Malawi',
        'mx' => 'Mexico',
        'my' => 'Malaysia',
        'mz' => 'Mozambique',
        'na' => 'Namibia',
        'nc' => 'New Caledonia',
        'ne' => 'Niger',
        'nf' => 'Norfolk Island',
        'ng' => 'Nigeria',
        'ni' => 'Nicaragua',
        'nl' => 'Netherlands',
        'no' => 'Norway',
        'np' => 'Nepal',
        'nr' => 'Nauru',
        'nt' => 'Neutral Zone',
        'nu' => 'Niue',
        'nz' => 'New Zealand',
        'om' => 'Oman',
        'pa' => 'Panama',
        'pe' => 'Peru',
        'pf' => 'French Polynesia',
        'pg' => 'Papua New Guinea',
        'ph' => 'Philippines',
        'pk' => 'Pakistan',
        'pl' => 'Poland',
        'pm' => 'St. Pierre and Miquelon',
        'pn' => 'Pitcairn',
        'pr' => 'Puerto Rico',
        'pt' => 'Portugal',
        'pw' => 'Palau',
        'py' => 'Paraguay',
        'qa' => 'Qatar',
        're' => 'Reunion',
        'ro' => 'Romania',
        'ru' => 'Russia',
        'rw' => 'Rwanda',
        'sa' => 'Saudi Arabia',
        'sb' => 'Solomon Islands',
        'sc' => 'Seychelles',
        'sd' => 'Sudan',
        'se' => 'Sweden',
        'sg' => 'Singapore',
        'sh' => 'St. Helena',
        'si' => 'Slovenia',
        'sj' => 'Svalbard and Jan Mayen Islands',
        'sk' => 'Slovakia (Slovak Republic)',
        'sl' => 'Sierra Leone',
        'sm' => 'San Marino',
        'sn' => 'Senegal',
        'so' => 'Somalia',
        'sr' => 'Suriname',
        'st' => 'Sao Tome and Principe',
        'sv' => 'El Salvador',
        'sy' => 'Syria',
        'sz' => 'Swaziland',
        'tc' => 'Turks and Caicos Islands',
        'td' => 'Chad',
        'tf' => 'French Southern Territories',
        'tg' => 'Togo',
        'th' => 'Thailand',
        'tj' => 'Tajikistan',
        'tk' => 'Tokelau',
        'tm' => 'Turkmenistan',
        'tn' => 'Tunisia',
        'to' => 'Tonga',
        'tp' => 'East Timor',
        'tr' => 'Turkey',
        'tt' => 'Trinidad, Tobago',
        'tv' => 'Tuvalu',
        'tw' => 'Taiwan',
        'tz' => 'Tanzania',
        'ua' => 'Ukraine',
        'ug' => 'Uganda',
        'uk' => 'United Kingdom',
        'um' => 'United States Minor Islands',
        'us' => 'United States of America',
        'uy' => 'Uruguay',
        'uz' => 'Uzbekistan',
        'va' => 'Vatican City',
        'vc' => 'Saint Vincent, Grenadines',
        've' => 'Venezuela',
        'vg' => 'Virgin Islands (British)',
        'vi' => 'Virgin Islands (USA)',
        'vn' => 'Viet Nam',
        'vu' => 'Vanuatu',
        'wf' => 'Wallis and Futuna Islands',
        'ws' => 'Samoa',
        'ye' => 'Yemen',
        'yt' => 'Mayotte',
        'yu' => 'Yugoslavia',
        'za' => 'South Africa',
        'zm' => 'Zambia',
        'zr' => 'Zaire',
        'zw' => 'Zimbabwe',
    );

    /**
     * Should a dummy entry be prepended
     *
     * @var boolean
     */
    protected $_useDummyEntry = true;

    /**
     * If the United States of America should be listed first in the alphabetical list of countries
     *
     * @var boolean
     */
    protected $_unitedStatesFirst = false;

    /**
     * Set the dummy text
     *
     * @param string $dummyText
     * @return Bear_Form_Element_Country
     */
    public function setDummyText($dummyText)
    {
        $this->_dummyText = $dummyText;
        return $this;
    }

    /**
     * Get the dummy text
     *
     * @return string
     */
    public function getDummyText()
    {
        return $this->_dummyText;
    }

    /**
     * Determine if abbreviated country values should be returned
     *
     * @param boolean $flag
     * @return Bear_Form_Element_Country
     */
    public function setReturnAbbreviatedCountryValues($flag)
    {
        $this->_returnAbbreviatedCountryValues = $flag;
        return $this;
    }

    /**
     * Get whether abbreviated country values should be returned or not
     *
     * @return boolean
     */
    public function getReturnAbbreviatedCountryValues()
    {
        return $this->_returnAbbreviatedCountryValues;
    }

    /**
     * Determine if a dummy entry should be prepended to the list
     *
     * @param boolean $flag
     * @return Bear_Form_Element_Country
     */
    public function setPrependEntry($flag)
    {
        $this->_useDummyEntry = $flag;
        return $this;
    }

    /**
     * Get whether a dummy entry shuld be prepended to the list
     *
     * @return boolean
     */
    public function getPrependEntry()
    {
        return $this->_useDummyEntry;
    }

    /**
     * Set the list of countries
     *
     * @param array $countries
     * @return Bear_Form_Element_Country
     */
    public function setCountries($countries)
    {
        $this->_countries = $countries;
        return $this;
    }

    /**
     * Get the list of countries
     *
     * @return array
     */
    public function getCountries()
    {
        return $this->_countries;
    }

    /**
     * Whether the United States of America should be first! WE'RE NUMBER 1!!
     *
     * @param boolean $unitedStatesFirst
     * @return Bear_Form_Element_Country
     */
    public function setUnitedStatesFirst($unitedStatesFirst)
    {
        $this->_unitedStatesFirst = $unitedStatesFirst;
        return $this;
    }

    /**
     * Whether the United States of America should be first
     *
     * @return boolean
     */
    public function getUnitedStatesFirst()
    {
        return $this->_unitedStatesFirst;
    }

    /**
     * Retrieve options array
     *
     * @return array
     */
    protected function _getMultiOptions()
    {
        if (!$this->options) {

            $this->options = $this->_countries;

            // sort by country name
            asort($this->options);

            if (! $this->_returnAbbreviatedCountryValues) {
                // replace array keys with the values
                $this->options = array_combine($this->options, $this->options);
            }

            if ($this->_unitedStatesFirst) {
                unset($this->options['us']);
                $this->options = array('us' => $this->_countries['us']) + $this->options;
            }

            // unshift the dummy entry to the top of the array
            if ($this->_useDummyEntry) {
                $this->options = array('' => $this->_dummyText) + $this->options;
            }
        }

        return $this->options;
    }

}
