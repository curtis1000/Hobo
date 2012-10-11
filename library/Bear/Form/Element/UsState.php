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
 * US state form element
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_Form
 */
class Bear_Form_Element_UsState extends Bear_Form_Element_Select
{

    /**
     * Dummy text
     * @var string
     */
    protected $_dummyText = "Choose...";

    /**
     * Should abbreviated state name values be returned?
     * @var boolean
     */
    protected $_returnAbbreviatedStateValues = false;

    /**
     * States
     * @var array
     */
    protected $_states = array(
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
        'WY' => 'Wyoming'
    );

    /**
     * Should a dummy entry be prepended
     * @var boolean
     */
    protected $_useDummyEntry = true;

    /**
     * Set the dummy text
     *
     * @param string $text
     * @return Bear_Form_Element_UsState
     */
    public function setDummyText($dummyText)
    {
        $this->_dummyText = $dummyText;
        return $this;
    }

    /**
     * Determine if abbreviated state values should be returned
     *
     * @param boolean $flag
     * @return Bear_Form_Element_UsState
     */
    public function setReturnAbbreviatedStateValues($flag)
    {
        $this->_returnAbbreviatedStateValues = $flag;
        return $this;
    }

    /**
     * Determine if a dummy entry should be prepended to the list
     *
     * @param boolean $flag
     * @return Bear_Form_Element_UsState
     */
    public function setPrependEntry($flag)
    {
        $this->_useDummyEntry = $flag;
        return $this;
    }

    /**
     * Retrieve options array
     *
     * @return array
     */
    protected function _getMultiOptions()
    {
        if (!$this->options) {
            if ($this->_useDummyEntry) {
                $this->options[""] = $this->_dummyText;
            }

            foreach ($this->_states as $stateAbbr => $stateName) {
                if ($this->_returnAbbreviatedStateValues) {
                    $this->options[$stateAbbr] = $stateName;
                } else {
                    $this->options[$stateName] = $stateName;
                }
            }
        }

        return $this->options;
    }

}
