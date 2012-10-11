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
 * Date time element
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_Form
 * @since 2.0.0
 */
class Bear_Form_Element_DateTime extends Zend_Form_Element_Xhtml
{

    /**
     * Date time format
     * @var string
     */
    protected $_dateTimeFormat = "MMMM d, yyyy h:mm:ss a";

    /**
     * Day
     * @var integer
     */
    protected $_day;

    /**
     * Hour
     * @var integer
     */
    protected $_hour;

    /**
     * Minute
     * @var integer
     */
    protected $_minute;

    /**
     * Month
     * @var integer
     */
    protected $_month;

    /**
     * Flag for autoregistering a date validator
     * @var boolean
     */
    protected $_registerDateValidator = true;

    /**
     * Second
     * @var integer
     */
    protected $_second;

    /**
     * Year range information
     * @var array
     */
    protected $_yearsRange;

    /**
     * Year
     * @var integer
     */
    protected $_year;

    /**
     * Class
     * @var string
     */
    public $class = "input-type input-type-text input-attribute-type input-attribute-composite";

    /**
     * Constructor
     *
     * @param string|array|Zend_Config $spec
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
     * Get the date time format
     *
     * @return string
     */
    public function getDateTimeFormat()
    {
        return $this->_dateTimeFormat;
    }

    /**
     * Get the day
     *
     * @return integer
     */
    public function getDay()
    {
        return $this->_day;
    }

    /**
     * Get the hour
     *
     * @return integer
     */
    public function getHour()
    {
        return $this->_hour;
    }

    /**
     * Get the minute
     *
     * @return integer
     */
    public function getMinute()
    {
        return $this->_minute;
    }

    /**
     * Get the month
     *
     * @return integer
     */
    public function getMonth()
    {
        return $this->_month;
    }

    /**
     * Get the second
     *
     * @return integer
     */
    public function getSecond()
    {
        return $this->_second;
    }

    /**
     * Get the year
     *
     * @return integer
     */
    public function getYear()
    {
        return $this->_year;
    }

    /**
     * Get the years range information
     *
     * @return array
     */
    public function getYearsRange()
    {
        if (!$this->_yearsRange) {
            $this->_yearsRange = range(
                date("Y"),
                date("Y") - 100,
                1
            );
        }

        return $this->_yearsRange;
    }

    /**
     * Get the filtered element value
     *
     * @return Zend_Date
     */
    public function getValue()
    {
        if ($this->getDay() && $this->getMonth() && $this->getYear()) {
            /** Zend_Date */
            require_once "Zend/Date.php";

            $date = new Zend_Date(array(
                "day"    => $this->getDay(),
                "month"  => $this->getMonth(),
                "year"   => $this->getYear(),
                "hour"   => $this->getHour(),
                "minute" => $this->getMinute(),
                "second" => $this->getSecond()
            ));

            return $date;
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
        if ($this->registerDateValidator()) {
            if (!$this->getValidator('Date')) {
                $this->addValidator('Date', true);
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
                 ->addDecorator("DateTime")
                 ->addDecorator("Description", array("tag" => "p", "class" => "description"))
                 ->addDecorator("HtmlTag", array("tag" => "div", "class" => "element-content"))
                 ->addDecorator("Label", array("class" => "element-label"))
                 ->addDecorator("LiWrapper");
        }
    }

    /**
     * Get status of auto-register date validator flag
     *
     * @return boolean
     */
    public function registerDateValidator()
    {
        return $this->_registerDateValidator;
    }

    /**
     * Set the datetime format
     *
     * @return Bear_Form_Element_DateTime
     */
    public function setDateTimeFormat($dateTimeFormat)
    {
        $this->_dateTimeFormat = $dateTimeFormat;
        return $this;
    }

    /**
     * Set the day
     *
     * @param string $day
     * @return Bear_Form_Element_DateTime
     */
    public function setDay($day)
    {
        $this->_day = $day;
        return $this;
    }

    /**
     * Set the hour
     *
     * @param string $hour
     * @return Bear_Form_Element_DateTime
     */
    public function setHour($hour)
    {
        $this->_hour = $hour;
        return $this;
    }

    /**
     * Set the minute
     *
     * @param string $minute
     * @return Bear_Form_Element_DateTime
     */
    public function setMinute($minute)
    {
        $this->_minute = $minute;
        return $this;
    }

    /**
     * Set the month
     *
     * @param string $month
     * @return Bear_Form_Element_DateTime
     */
    public function setMonth($month)
    {
        $this->_month = $month;
        return $this;
    }

    /**
     * Set flag indicating whether or not to auto-register a date validator
     *
     * @param boolean $flag
     * @return Bear_Form_Element_DateTime
     */
    public function setRegisterDateValidator($flag)
    {
        $this->_registerDateValidator = (bool) $flag;
        return $this;
    }

    /**
     * Set the second
     *
     * @param string $second
     * @return Bear_Form_Element_DateTime
     */
    public function setSecond($second)
    {
        $this->_second = $second;
        return $this;
    }

    /**
     * Set element value
     *
     * @param  mixed $value
     * @return Bear_Form_Element_DateTime
     */
    public function setValue($value)
    {
        /** Zend_Date */
        require_once "Zend/Date.php";

        if (is_string($value) && Zend_Date::isDate($value, $this->getDateTimeFormat())) {
            $value = new Zend_Date($value, $this->getDateTimeFormat());

            $this->setDay($value->get(Zend_Date::DAY_SHORT))
                 ->setMonth($value->get(Zend_Date::MONTH_SHORT))
                 ->setYear($value->get(Zend_Date::YEAR))
                 ->setHour($value->get(Zend_Date::HOUR_SHORT))
                 ->setMinute($value->get(Zend_Date::MINUTE_SHORT))
                 ->setSecond($value->get(Zend_Date::SECOND_SHORT));
        } elseif (is_array($value)) {
            $this->setDay($value["day"])
                 ->setMonth($value["month"])
                 ->setYear($value["year"])
                 ->setHour($value["hour"])
                 ->setMinute($value["minute"])
                 ->setSecond($value["second"]);
        } elseif ($value instanceof Zend_Date) {
            $this->setDay($value->get(Zend_Date::DAY_SHORT))
                 ->setMonth($value->get(Zend_Date::MONTH_SHORT))
                 ->setYear($value->get(Zend_Date::YEAR))
                 ->setHour($value->get(Zend_Date::HOUR_SHORT))
                 ->setMinute($value->get(Zend_Date::MINUTE_SHORT))
                 ->setSecond($value->get(Zend_Date::SECOND_SHORT));
        } elseif (is_null($value)) {
            $this->setDay(null)
                 ->setMonth(null)
                 ->setYear(null)
                 ->setHour(null)
                 ->setMinute(null)
                 ->setSecond(null);
        } else {
            throw new UnexpectedValueException("Invalid date value");
        }

        return $this;
    }

    /**
     * Set the year
     *
     * @param string $year
     * @return Bear_Form_Element_DateTime
     */
    public function setYear($year)
    {
        $this->_year = $year;
        return $this;
    }

    /**
     * Set the years range information
     *
     * @param integer $startYear
     * @param integer $endYear
     * @param integer $step
     * @return Bear_Form_Element_DateTime
     */
    public function setYearsRange($startYear, $endYear, $step = 1)
    {
        $this->_yearsRange = range(
            $startYear,
            $endYear,
            $step
        );
        return $this;
    }

}
