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
 * Time length element
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_Form
 * @since 2.0.0
 */
class Bear_Form_Element_TimeLength extends Zend_Form_Element_Xhtml
{

    /**
     * Hours
     * @var integer
     */
    protected $_hours;

    /**
     * Minutes
     * @var integer
     */
    protected $_minutes;

    /**
     * Flag for autoregistering a timeLength validator
     * @var boolean
     */
    protected $_registerTimeLengthValidator = true;

    /**
     * Seconds
     * @var integer
     */
    protected $_seconds;

    /**
     * Class
     * @var string
     */
    public $class = "input-type input-type-text input-attribute-type input-attribute-composite";

    /**
     * Constructor
     *
     * @param mixed $spec
     * @param array $options
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
     * Get the hours
     *
     * @return integer
     */
    public function getHours()
    {
        return $this->_hours;
    }

    /**
     * Get the minutes
     *
     * @return integer
     */
    public function getMinutes()
    {
        return $this->_minutes;
    }

    /**
     * Get the seconds
     *
     * @return integer
     */
    public function getSeconds()
    {
        return $this->_seconds;
    }

    /**
     * Get the filtered element value
     *
     * @return string
     */
    public function getValue()
    {
        if ((int) $this->getHours() || (int) $this->getMinutes() || (int) $this->getSeconds()) {
            return sprintf(
                "%d:%02d:%02d",
                $this->getHours(),
                $this->getMinutes(),
                $this->getSeconds()
            );
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
        if ($this->registerTimeLengthValidator()) {
            if (!$this->getValidator('TimeLength')) {
                $this->addValidator('TimeLength', true);
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
                 ->addDecorator("TimeLength")
                 ->addDecorator("Description", array("tag" => "p", "class" => "description"))
                 ->addDecorator("HtmlTag", array("tag" => "div", "class" => "element-content"))
                 ->addDecorator("Label", array("class" => "element-label"))
                 ->addDecorator("LiWrapper");
        }
    }

    /**
     * Get status of auto-register inArray validator flag
     *
     * @return boolean
     */
    public function registerTimeLengthValidator()
    {
        return $this->_registerTimeLengthValidator;
    }

    /**
     * Set the hours
     *
     * @param integer $hours
     * @return OneGreatTown_Form_Element_TimeLength
     */
    public function setHours($hours)
    {
        $this->_hours = $hours;
        return $this;
    }

    /**
     * Set the minutes
     *
     * @param integer $minutes
     * @return OneGreatTown_Form_Element_TimeLength
     */
    public function setMinutes($minutes)
    {
        $this->_minutes = $minutes;
        return $this;
    }

    /**
     * Set flag indicating whether or not to auto-register a timeLength validator
     *
     * @param boolean $flag
     * @return OneGreatTown_Form_Element_TimeLength
     */
    public function setRegisterTimeLengthValidator($flag)
    {
        $this->_registerTimeLengthValidator = (bool) $flag;
        return $this;
    }

    /**
     * Set the seconds
     *
     * @param integer $seconds
     * @return OneGreatTown_Form_Element_TimeLength
     */
    public function setSeconds($seconds)
    {
        $this->_seconds = $seconds;
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
        if (is_string($value) && preg_match("#^(\d*):(\d{2}):(\d{2})$#", $value, $matches)) {
            $this->setHours($matches[1])
                 ->setMinutes($matches[2])
                 ->setSeconds($matches[3]);
        } elseif (is_array($value) && isset($value["hours"]) && isset($value["minutes"]) && isset($value["seconds"])) {
            $this->setHours($value["hours"])
                 ->setMinutes($value["minutes"])
                 ->setSeconds($value["seconds"]);
        } elseif (is_null($value)) {
            $this->setHours(null)
                 ->setMinutes(null)
                 ->setSeconds(null);
        } else {
            throw new Zend_Form_Element_Exception("Invalid length format");
        }

        return $this;
    }

}
