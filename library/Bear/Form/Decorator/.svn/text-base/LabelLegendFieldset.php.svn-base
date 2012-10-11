<?php
/**
 * Bear
 *
 * @category Bear
 * @package Bear_Form
 */

/** Zend_Form_Decorator_Fieldset */
require_once "Zend/Form/Decorator/Fieldset.php";

/**
 * Fieldset/legend decorator that uses an elements label as the legend
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_Form
 * @since 2.0.0
 */
class Bear_Form_Decorator_LabelLegendFieldset extends Zend_Form_Decorator_Fieldset
{

    /**
     * Attribs that should be removed prior to rendering
     * @var array
     */
    public $stripAttribs = array(
        "action",
        "enctype",
        "helper",
        "method",
        "name",
        "class"
    );

    /**
     * Constructor
     *
     * @param  array|Zend_Config $options
     * @return void
     */
    public function __construct($options = null)
    {
        $this->setOption("optionalPrefix", "");
        $this->setOption("optionalSuffix", "");
        $this->setOption("requiredPrefix", "");
        $this->setOption("requiredSuffix", "*");

        parent::__construct($options);
    }

    /**
     * Load an optional/required suffix/prefix key
     *
     * @param  string $key
     * @return void
     */
    protected function _loadOptReqKey($key)
    {
        if (!isset($this->$key)) {
            $value = $this->getOption($key);
            $this->$key = (string) $value;
            if (null !== $value) {
                $this->removeOption($key);
            }
        }
    }

    /**
     * Overloading
     *
     * Currently overloads:
     *
     * - getOpt(ional)Prefix()
     * - getOpt(ional)Suffix()
     * - getReq(uired)Prefix()
     * - getReq(uired)Suffix()
     * - setOpt(ional)Prefix()
     * - setOpt(ional)Suffix()
     * - setReq(uired)Prefix()
     * - setReq(uired)Suffix()
     *
     * @param  string $method
     * @param  array $args
     * @return mixed
     * @throws Zend_Form_Exception for unsupported methods
     */
    public function __call($method, $args)
    {
        $tail = substr($method, -6);
        $head = substr($method, 0, 3);
        if (in_array($head, array("get", "set"))
            && (("Prefix" == $tail) || ("Suffix" == $tail))
        ) {
            $position = substr($method, -6);
            $type     = strtolower(substr($method, 3, 3));
            switch ($type) {
                case "req":
                    $key = "required" . $position;
                    break;
                case "opt":
                    $key = "optional" . $position;
                    break;
                default:
                    require_once "Zend/Form/Exception.php";
                    throw new Zend_Form_Exception(sprintf("Invalid method '%s' called in Label decorator, and detected as type %s", $method, $type));
            }

            switch ($head) {
                case "set":
                    if (0 === count($args)) {
                        require_once "Zend/Form/Exception.php";
                        throw new Zend_Form_Exception(sprintf("Method '%s' requires at least one argument; none provided", $method));
                    }
                    $value = array_shift($args);
                    $this->$key = $value;
                    return $this;
                case "get":
                default:
                    if (null === ($element = $this->getElement())) {
                        $this->_loadOptReqKey($key);
                    } elseif (isset($element->$key)) {
                        $this->$key = (string) $element->$key;
                    } else {
                        $this->_loadOptReqKey($key);
                    }
                    return $this->$key;
            }
        }

        require_once "Zend/Form/Exception.php";
        throw new Zend_Form_Exception(sprintf("Invalid method '%s' called in Label decorator", $method));
    }

    /**
     * Get the legend
     *
     * @return string
     */
    public function getLegend()
    {
        if (null === ($element = $this->getElement())) {
            return "";
        }

        $label = $element->getLabel();
        $label = trim($label);

        if (empty($label)) {
            return "";
        }

        if (null !== ($translator = $element->getTranslator())) {
            $label = $translator->translate($label);
        }

        $optPrefix = $this->getOptPrefix();
        $optSuffix = $this->getOptSuffix();
        $reqPrefix = $this->getReqPrefix();
        $reqSuffix = $this->getReqSuffix();
        $separator = $this->getSeparator();

        if (!empty($label)) {
            if ($element->isRequired()) {
                $label = $reqPrefix . $label . $reqSuffix;
            } else {
                $label = $optPrefix . $label . $optSuffix;
            }
        }

        return $label;
    }

}
