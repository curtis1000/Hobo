<?php
/**
 * Bear
 *
 * @category Bear
 * @package Bear_Form
 */

/** Zend_Form_Decorator_Abstract */
require_once "Zend/Form/Decorator/Abstract.php";

/**
 * Date time decorator
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_Form
 * @since 2.0.0
 */
class Bear_Form_Decorator_DateTime extends Zend_Form_Decorator_Abstract
{

    /**#@+
     * Date constant
     * @var string
     */
    const DAY              = "dd";
    const DAY_SHORT        = "d";
    const MONTH            = "MM";
    const MONTH_SHORT      = "M";
    const MONTH_NAME       = "MMMM";
    const MONTH_NAME_SHORT = "MMM";
    const YEAR             = "yyyy";
    const YEAR_SHORT       = "yy";
    const HOUR             = "HH";
    const HOUR_SHORT       = "H";
    const HOUR_AM          = "hh";
    const HOUR_AM_SHORT    = "h";
    const MINUTE           = "mm";
    const MINUTE_SHORT     = "m";
    const SECOND           = "ss";
    const SECOND_SHORT     = "s";
    const AM_PM            = "a";
    /**#@-*/

    /**
     * Retrieve element attributes
     *
     * Set id to element name and/or array item.
     *
     * @return array
     */
    public function getElementAttribs()
    {
        if (null === ($element = $this->getElement())) {
            return null;
        }

        $attribs = $element->getAttribs();
        if (isset($attribs['helper'])) {
            unset($attribs['helper']);
        }

        return $attribs;
    }

    /**
     * Decorate content and/or element
     *
     * @param string $content
     * @return string
     * @throws Zend_Dorm_Decorator_Exception
     */
    public function render($content)
    {
        $element = $this->getElement();
        if (!$element instanceof Bear_Form_Element_DateTime) {
            return $content;
        }

        $view = $element->getView();
        if (!$view instanceof Zend_View_Interface) {
            return $content;
        }

        $day    = $element->getDay();
        $month  = $element->getMonth();
        $year   = $element->getYear();
        $hour   = $element->getHour();
        $minute = $element->getMinute();
        $second = $element->getSecond();

        $name      = $element->getFullyQualifiedName();
        $separator = $this->getSeparator();

        preg_match_all(
            "#(.*?)\b#",
            $element->getDateTimeFormat(),
            $matches
        );

        $markup = "";

        foreach ($matches[1] as $part) {
            switch ($part) {
                case self::DAY:
                    $options = array();
                    for ($i = 1; $i <= 31; ++$i) {
                        $options[$i] = sprintf(
                            "%02d",
                            $i
                        );
                    }

                    $markup .= $view->formSelect(
                        "{$name}[day]",
                        $day,
                        array(),
                        $options
                    );
                    break;

                case self::DAY_SHORT:
                    $options = array();
                    for ($i = 1; $i < 31; ++$i) {
                        $options[$i] = $i;
                    }

                    $markup .= $view->formSelect(
                        "{$name}[day]",
                        $day,
                        array(),
                        $options
                    );
                    break;

                case self::MONTH:
                    $months = Zend_Locale::getTranslationList("months");

                    $options = array();
                    foreach ($months["format"]["narrow"] as $value => $label) {
                        $options[$value] = sprintf(
                            "%02d",
                            $label
                        );
                    }

                    $markup .= $view->formSelect(
                        "{$name}[month]",
                        $month,
                        array(),
                        $options
                    );
                    break;

                case self::MONTH_SHORT:
                    $months = Zend_Locale::getTranslationList("months");

                    $options = array();
                    foreach ($months["format"]["narrow"] as $value => $label) {
                        $options[$value] = $label;
                    }

                    $markup .= $view->formSelect(
                        "{$name}[month]",
                        $month,
                        array(),
                        $options
                    );
                    break;

                case self::MONTH_NAME:
                    $months = Zend_Locale::getTranslationList("months");

                    $options = array();
                    foreach ($months["format"]["wide"] as $value => $label) {
                        $options[$value] = $label;
                    }

                    $markup .= $view->formSelect(
                        "{$name}[month]",
                        $month,
                        array(),
                        $options
                    );
                    break;

                case self::MONTH_NAME_SHORT:
                    $months = Zend_Locale::getTranslationList("months");

                    $options = array();
                    foreach ($months["format"]["abbreviated"] as $value => $label) {
                        $options[$value] = $label;
                    }

                    $markup .= $view->formSelect(
                        "{$name}[month]",
                        $month,
                        array(),
                        $options
                    );
                    break;

                case self::YEAR:
                    $markup .= $view->formSelect(
                        "{$name}[year]",
                        $year,
                        array(),
                        array_combine(
                            $element->getYearsRange(),
                            $element->getYearsRange()
                        )
                    );
                    break;

                case self::YEAR_SHORT:
                    $markup .= $view->formSelect(
                        "{$name}[year]",
                        $year,
                        array(),
                        array_combine(
                            $element->getYearsRange(),
                            $element->getYearsRange()
                        )
                    );
                    break;

                case self::HOUR:
                    $options = array();
                    for ($i = 0; $i < 24; ++$i) {
                        $options[$i] = sprintf(
                            "%02d",
                            $i
                        );
                    }

                    $markup .= $view->formSelect(
                        "{$name}[hour]",
                        $hour,
                        array(),
                        $options
                    );
                    break;

                case self::HOUR_SHORT:
                    $options = array();
                    for ($i = 0; $i < 24; ++$i) {
                        $options[$i] = $i;
                    }

                    $markup .= $view->formSelect(
                        "{$name}[hour]",
                        $hour,
                        array(),
                        $options
                    );
                    break;

                case self::HOUR_AM:
                    $options = array(
                        "12" => "12",
                        "1" => "01",
                        "2" => "02",
                        "3" => "03",
                        "4" => "04",
                        "5" => "05",
                        "6" => "06",
                        "7" => "07",
                        "8" => "08",
                        "9" => "09",
                        "10" => "10",
                        "11" => "11",
                    );

                    $markup .= $view->formSelect(
                        "{$name}[hour]",
                        $hour % 12,
                        array(),
                        $options
                    );
                    break;

                case self::HOUR_AM_SHORT:
                    $options = array(
                        "12" => "12",
                        "1" => "1",
                        "2" => "2",
                        "3" => "3",
                        "4" => "4",
                        "5" => "5",
                        "6" => "6",
                        "7" => "7",
                        "8" => "8",
                        "9" => "9",
                        "10" => "10",
                        "11" => "11",
                    );

                    $markup .= $view->formSelect(
                        "{$name}[hour]",
                        $hour % 12,
                        array(),
                        $options
                    );
                    break;

                case self::MINUTE:
                    $options = array();
                    for ($i = 0; $i < 60; ++$i) {
                        $options[$i] = sprintf(
                            "%02d",
                            $i
                        );
                    }

                    $markup .= $view->formSelect(
                        "{$name}[minute]",
                        $minute,
                        array(),
                        $options
                    );
                    break;

                case self::MINUTE_SHORT:
                    $options = array();
                    for ($i = 0; $i < 60; ++$i) {
                        $options[$i] = $i;
                    }

                    $markup .= $view->formSelect(
                        "{$name}[minute]",
                        $minute,
                        array(),
                        $options
                    );
                    break;

                case self::SECOND:
                    $options = array();
                    for ($i = 0; $i < 60; ++$i) {
                        $options[$i] = sprintf(
                            "%02d",
                            $i
                        );
                    }

                    $markup .= $view->formSelect(
                        "{$name}[second]",
                        $second,
                        array(),
                        $options
                    );
                    break;

                case self::SECOND_SHORT:
                    $options = array();
                    for ($i = 0; $i < 60; ++$i) {
                        $options[$i] = $i;
                    }

                    $markup .= $view->formSelect(
                        "{$name}[second]",
                        $second,
                        array(),
                        $options
                    );
                    break;

                case self::AM_PM:
                    $markup .= $view->formSelect(
                        "{$name}[ampm]",
                        floor($hour / 12) == 0 ? "am" : "pm",
                        array(),
                        array("am" => "AM", "pm" => "PM")
                    );
                    break;

                default:
                    $markup .= $part;
                    break;
            }
        }

        switch ($this->getPlacement()) {
            case self::PREPEND:
                return $markup . $this->getSeparator() . $content;
            case self::APPEND:
            default:
                return $content . $this->getSeparator() . $markup;
        }
    }

    /**
     * Get the element id
     *
     * @return string
     */
    protected function _getId()
    {
        $id = $this->getElement()->getName();

        if ($element instanceof Zend_Form_Element) {
            if (null !== ($belongsTo = $element->getBelongsTo())) {
                $belongsTo = preg_replace('/\[([^\]]+)\]/', '-$1', $belongsTo);
                $id = $belongsTo . '-' . $id;
            }
        }

        return $id;
    }

}
