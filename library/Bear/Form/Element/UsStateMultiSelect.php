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
 * US state multiselect form element
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_Form
 */
class Bear_Form_Element_UsStateMultiSelect extends Bear_Form_Element_UsState
{

    /**
     * 'multiple' attribute
     * @var string
     */
    public $multiple = 'multiple';

    /**
     * Use formSelect view helper by default
     * @var string
     */
    public $helper = 'formSelect';

    /**
     * Multiselect is an array of values by default
     * @var bool
     */
    protected $_isArray = true;

}