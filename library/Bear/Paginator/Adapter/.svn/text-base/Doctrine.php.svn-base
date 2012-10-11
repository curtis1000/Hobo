<?php
/**
 * Bear
 *
 * @category Bear
 * @package Bear_Pagination
 */

/** Zend_Paginator_Adapter_Interface */
require_once "Zend/Paginator/Adapter/Interface.php";

/**
 * Doctrine paginator adapter
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_Pagination
 */
class Bear_Paginator_Adapter_Doctrine extends Bear_Base_Abstract implements Zend_Paginator_Adapter_Interface
{

    /**
     * Doctrine query
     * @var Doctrine_Query
     */
    protected $_query;

    /**
     * Count
     *
     * @return integer
     */
    public function count()
    {
        return $this->getQuery()->count();
    }

    /**
     * Get the Doctrine table
     *
     * @return Doctrine_Table
     */
    public function getQuery()
    {
        if (!$this->_query) {
            /** Zend_Paginator_Exception */
            require_once "Zend/Paginator/Exception.php";
            throw new Zend_Paginator_Exception("No query set");
        }

        return $this->_query;
    }

    /**
     * Returns an collection of items for a page.
     *
     * @param  integer $offset Page offset
     * @param  integer $itemCountPerPage Number of items per page
     * @return array
     */
    public function getItems($offset, $itemCountPerPage)
    {
        return $this->getQuery()
                    ->limit($itemCountPerPage)
                    ->offset($offset)
                    ->execute();
    }

    /**
     * Set the Doctrine query
     *
     * @param Doctrine_Query_Abstract $query
     * @return PDC_Paginator_Adapter_Doctrine
     */
    public function setQuery(Doctrine_Query_Abstract $query)
    {
        $this->_query = $query;

        return $this;
    }

}
