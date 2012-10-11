<?php
/**
 * Bear
 *
 * @category Bear
 * @package Bear_Form
 */

/** Zend_Form_Decorator_Label */
require_once "Zend/Form/Decorator/Label.php";

/**
 * Label decorator
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_Form
 * @since 2.0.0
 */
class Bear_Form_Decorator_Label extends Zend_Form_Decorator_Label
{

    /**
     * Constructor
     *
     * @param  array|Zend_Config $options
     * @return void
     */
    public function __construct($options = null)
    {
        if (!isset($options["optPrefix"]) && !isset($options["optionalPrefix"])) {
            $options["optionalPrefix"] = "";
        }

        if (!isset($options["optSuffix"]) && !isset($options["optionalSuffix"])) {
            $options["optionalSuffix"] = ":";
        }

        if (!isset($options["reqPrefix"]) && !isset($options["requiredPrefix"])) {
            $options["requiredPrefix"] = "";
        }

        if (!isset($options["reqSuffix"]) && !isset($options["requiredSuffix"])) {
            $options["requiredSuffix"] = ":*";
        }

        parent::__construct($options);
    }

}
