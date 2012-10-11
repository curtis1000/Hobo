<?php
/**
 * Bear
 *
 * @category Bear
 * @package Bear_Form
 */

/** Zend_Form_Element_Xhtml */
require_once "Zend/Form/Element/Xhtml.php";

/**
 * Phone number element
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_Form
 * @since 2.0.0
 */
class Bear_Form_Element_PhoneNumber extends Zend_Form_Element_Xhtml
{

    /**
     * Flag for allowing the extension
     * @var boolean
     */
    protected $_allowExtension = false;

    /**
     * Area code
     * @var integer
     */
    protected $_areaCode;

    /**
     * Extension
     * @var integer
     */
    protected $_extension;

    /**
     * Line
     * @var integer
     */
    protected $_line;

    /**
     * Prefix
     * @var integer
     */
    protected $_prefix;

    /**
     * Flag for autoregistering a phoneNumber validator
     * @var boolean
     */
    protected $_registerPhoneNumberValidator = true;

    /**
     * Class
     * @var string
     */
    public $class = "input-type input-type-text input-attribute-type input-attribute-composite";

    /**
     * Constructor
     *
     * @param mixed $spec
     * @param mixed $options
     */
    public function __construct($spec, $options = null)
    {
        $this->addPrefixPath(
            "Bear_Form",
            "Bear/Form"
        );

        parent::__construct($spec, $options);
    }

    /**
     * Get status of allowing the extension
     *
     * @return boolean
     */
    public function allowExtension()
    {
        return $this->_allowExtension;
    }

    /**
     * Get the area code
     *
     * @return string
     */
    public function getAreaCode()
    {
        return $this->_areaCode;
    }

    /**
     * Get the extension
     *
     * @return string
     */
    public function getExtension()
    {
        return $this->_extension;
    }

    /**
     * Get the line
     *
     * @return string
     */
    public function getLine()
    {
        return $this->_line;
    }

    /**
     * Get the prefix
     *
     * @return string
     */
    public function getPrefix()
    {
        return $this->_prefix;
    }

    /**
     * Get the value
     *
     * @return string
     */
    public function getValue()
    {
        if ($this->getAreaCode() && $this->getPrefix() && $this->getLine()) {
            $phoneNumber = "({$this->getAreaCode()}) {$this->getPrefix()}-{$this->getLine()}";

            if ($this->allowExtension() && $this->getExtension()) {
                $phoneNumber .= " ext. {$this->getExtension()}";
            }

            return $phoneNumber;
        }

        return null;
    }

    /**
     * Validate element value
     *
     * If a translation adapter is registered, any error messages will be
     * translated according to the current locale, using the given error code;
     * if no matching translation is found, the original message will be
     * utilized.
     *
     * Note: The *filtered* value is validated.
     *
     * @param mixed $value
     * @param mixed $context
     * @return boolean
     */
    public function isValid($value, $context = null)
    {
        if ($this->registerPhoneNumberValidator()) {
            if (!$this->getValidator('PhoneNumber')) {
                $this->addValidator('PhoneNumber', true);
            }
        }
        return parent::isValid($value, $context);
    }

    /**
     * Load default decorators
     *
     * @return void
     */
    public function loadDefaultDecorators()
    {
        if ($this->loadDefaultDecoratorsIsDisabled()) {
            return;
        }

        $decorators = $this->getDecorators();
        if (empty($decorators)) {
            $this->addDecorator("Errors")
                 ->addDecorator("PhoneNumber")
                 ->addDecorator("Description", array("tag" => "p", "class" => "description"))
                 ->addDecorator("HtmlTag", array("tag" => "div", "class" => "element-content"))
                 ->addDecorator("Label", array("class" => "element-label"))
                 ->addDecorator("LiWrapper");
        }
    }

    /**
     * Get status of auto-register phoneNumber validator flag
     *
     * @return boolean
     */
    public function registerPhoneNumberValidator()
    {
        return $this->_registerPhoneNumberValidator;
    }

    /**
     * Set the area code
     *
     * @param string $areaCode
     * @return Bear_Form_Element_PhoneNumber
     */
    public function setAreaCode($areaCode)
    {
        $this->_areaCode = $areaCode;
        return $this;
    }

    /**
     * Set the extension
     *
     * @param string $extension
     * @return Bear_Form_Element_PhoneNumber
     */
    public function setExtension($extension)
    {
        $this->_extension = $extension;
        return $this;
    }

    /**
     * Set the line
     *
     * @param string $line
     * @return Bear_Form_Element_PhoneNumber
     */
    public function setLine($line)
    {
        $this->_line = $line;
        return $this;
    }

    /**
     * Set the prefix
     *
     * @param string $prefix
     * @return Bear_Form_Element_PhoneNumber
     */
    public function setPrefix($prefix)
    {
        $this->_prefix = $prefix;
        return $this;
    }

    /**
     * Set flag indicating whether or not to auto-register a phoneNumber validator
     *
     * @param boolean $flag
     * @return Bear_Form_Element_PhoneNumber
     */
    public function setRegisterPhoneNumberValidator($flag)
    {
        $this->_registerPhoneNumberValidator = (bool) $flag;
        return $this;
    }

    /**
     * Set a flag indicated if the extension should be allowed
     *
     * @param boolean $flag
     * @return Bear_Form_Element_PhoneNumber
     */
    public function setAllowExtension($flag)
    {
        $this->_allowExtension = (boolean) $flag;
        return $this;
    }

    /**
     * Set element value
     *
     * @param  mixed $value
     * @return OneGreatTown_Form_Element_TimeLength
     */
    public function setValue($value)
    {
        if (is_string($value) && preg_match("#^\((\d{3})\) (\d{3})\-(\d{4})( ext. (\d*))?$#", $value, $matches)) {
            $this->setAreaCode($matches[1])
                 ->setPrefix($matches[2])
                 ->setLine($matches[3]);

            if (isset($matches[5])) {
                $this->setExtension($matches[5]);
            }
        } elseif (is_array($value) && isset($value["areaCode"]) && isset($value["prefix"]) && isset($value["line"])) {
            $this->setAreaCode($value["areaCode"])
                 ->setPrefix($value["prefix"])
                 ->setLine($value["line"]);

            if (isset($value["extension"])) {
                $this->setExtension($value["extension"]);
            }
        } elseif (is_null($value)) {
            $this->setAreaCode(null)
                 ->setPrefix(null)
                 ->setLine(null)
                 ->setExtension(null);
        } else {
            throw new Zend_Form_Element_Exception("Invalid phone format");
        }

        return $this;
    }

}
