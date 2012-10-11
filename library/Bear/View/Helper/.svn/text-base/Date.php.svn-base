<?php
/**
 * Bear
 *
 * @category Bear
 * @package Bear_View
 * @author Konr Ness <kness@sierra-bravo.com>
 */

/**
 * Date formatting view helper
 *
 * @category Bear
 * @package Bear_View
 * @author Konr Ness <kness@sierra-bravo.com>
 * @version $Id$
 */
class Bear_View_Helper_Date
{
    /**
     * Default date foramt
     *
     * @var string
     */
    protected $_defaultDateFormat = 'n/j/Y';
    
    /**
     * Default unknown value
     *
     * @var string
     */
    protected $_defaultUnknown = '-';
    
    /**
     * Format a date
     * 
     * Accepts timestamps, MySQL DATETIME, and any other formats
     * that are strtotime() parseable
     *
     * @param string|int $date    Date in timestamp or string format
     * @param string     $format  OPTIONAL Desired PHP date format
     * @param string     $default OPTIONAL Default value for unknown values
     * @return string
     */
    public function date($date = null, $format = null, $default = null){
        
        if($format === null){
            $format = $this->getDefaultDateFormat();
        }
        
        if (is_null($date)) {
            $timestamp = time();
        } else {
            // numeric indicates a timestamp, otherwise is likely in
            // a MySQL datetime format or other strtotime parseable format
            $timestamp = is_numeric($date) ? $date : strtotime($date);
        }
        
        if($timestamp){
            return date($format, $timestamp);
        }else{
            return is_string($default) ? $default : $this->getDefaultUnknownValue();
        }
        
    }
    
    /**
     * Set the default date format
     *
     * @param string $dateFormat Default date format
     * @return Project_View_Helper_Date
     */
    public function setDefaultDateFormat($dateFormat)
    {
        $this->_defaultDateFormat = $dateFormat;
    }
    
    /**
     * Get the default date format
     *
     * @return string Default date format
     */
    public function getDefaultDateFormat()
    {
        return $this->_defaultDateFormat;
    }
    
    /**
     * Set the default unknown value
     *
     * @param string $defaultUnknown
     */
    public function setDefaultUnknownValue($defaultUnknown)
    {
        $this->_defaultUnknown = $defaultUnknown;
    }
    
    /**
     * Get the default unknown value
     *
     * @return string
     */
    public function getDefaultUnknownValue()
    {
        return $this->_defaultUnknown;
    }
}