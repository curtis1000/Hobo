<?php
/**
 * Bear
 *
 * @category Bear
 * @package Bear_Validate
 */

/** Zend_Validate_Abstract */
require_once 'Zend/Validate/Abstract.php';

/**
 * Class for Doctrine database record validation
 *
 * @category Bear
 * @package Bear_Validate
 */
abstract class Bear_Validate_Doctrine_Abstract extends Zend_Validate_Abstract
{

    /**
     * Error constants
     */
    const ERROR_NO_RECORD_FOUND = 'noRecordFound';
    const ERROR_RECORD_FOUND    = 'recordFound';

    /**
     * @var array Message templates
     */
    protected $_messageTemplates = array(
        self::ERROR_NO_RECORD_FOUND => 'No record matching %value% was found',
        self::ERROR_RECORD_FOUND    => 'A record matching %value% was found',
    );

    /**
     * @var string|array
     */
    protected $_exclude;

    /**
     * @var string
     */
    protected $_field;

    /**
     * Additional options
     * @var array
     */
    protected $_options = array();

    /**
     * @var Doctrine_Table
     */
    protected $_table;

    /**
     * Constructor
     *
     * @param array|Zend_Config $options
     */
    public function __construct($options = null)
    {
        if ($options instanceof Zend_Config) {
            $this->setConfig($options);
        } elseif (is_array($options)) {
            $this->setOptions($options);
        }
    }

    /**
     * Get the exclude clause
     *
     * @return string|array
     */
    public function getExclude()
    {
        return $this->_exclude;
    }

    /**
     * Get the field
     *
     * @return string|array
     */
    public function getField()
    {
        return $this->_field;
    }

    /**
     * Get the table
     *
     * @return Doctrine_Table
     */
    public function getTable()
    {
        return $this->_table;
    }

    /**
     * Set the options from a Zend_Config object
     *
     * @param Zend_Config $config
     * @return Bear_Base_Abstract
     */
    public function setConfig(Zend_Config $config)
    {
        return $this->setOptions($config->toArray());
    }

    /**
     * Set the exclude clause
     *
     * @param string|array $exclude
     * @return Bear_Validate_Doctrine_Abstract
     */
    public function setExclude($exclude)
    {
        $this->_exclude = $exclude;
        return $this;
    }

    /**
     * Set the field
     *
     * @param string $field
     * @return Bear_Validate_Doctrine_Abstract
     */
    public function setField($field)
    {
        $this->_field = (string) $field;
        return $this;
    }

    /**
     * Set the options from an array
     *
     * @param array $options
     * @return Bear_Base_Abstract
     */
    public function setOptions(array $options)
    {
        foreach ($options as $key => $value) {
            $method = "set" . ucFirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            } else {
                $this->_options[$key] = $value;
            }
        }
        return $this;
    }

    /**
     * Set the Doctrine table
     *
     * @param Doctrine_Table $table
     * @return Bear_Validate_Doctrine_Abstract
     */
    public function setTable(Doctrine_Table $table)
    {
        $this->_table = $table;
        return $this;
    }

    /**
     * Setup the query object
     *
     * @param string $value
     * @return Doctrine_Query
     */
    protected function _query($value)
    {
        $connection = $this->getTable()->getConnection();
        $query      = $this->getTable()->createQuery();
        $exclude    = $this->getExclude();

        $query->where($connection->quoteIdentifier($this->getField()) . " = ?", $value);

        if ($exclude) {
            if (is_array($exclude)) {
                $query->andWhere($connection->quoteIdentifier($exclude["field"]) . " != ?", $exclude["value"]);
            } else {
                $query->andWhere($exclude);
            }
        }

        $query->limit(1);

        return $query;
    }

}
