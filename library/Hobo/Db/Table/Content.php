<?php

class Hobo_Db_Table_Content extends Hobo_Db_Table
{
    protected $_name = 'hobo_content';
    protected $_rowClass = 'Hobo_Db_Table_Row_Content';

    /**
     * @param $params
     * @return null|Zend_Db_Table_Row_Abstract
     */
    public function selectLatest($params)
    {
        $select = $this->select()
                       // just in case isGlobal wasn't filtered in the controller (coming from ajax req),
                       // is_string is necessary, cause 0 == "anything" is true
                       ->where('isGlobal = ?', ($params['isGlobal'] === true || is_string($params['isGlobal']) && $params['isGlobal'] == 'true') ? 1 : 0)
                       ->where('routeName = ?', $params['routeName'])
                       ->where('handle = ?', $params['handle'])
                       ->order('id desc')
                       ->limit(1);

        return $this->fetchRow($select);
    }

    /**
     * What should the next revision number be for the given arguments?
     * @param $params
     * @return int
     */
    public function getNextRevision($params)
    {
        $select = $this->select()
                       ->where('isGlobal = ?', $params['isGlobal'])
                       ->where('handle = ?', $params['handle'])
                       ->order('revision desc')
                       ->limit(1);

        if (! $params['isGlobal']) {
            $select->where('routeName = ?', $params['routeName']);
        }

        $contentRow = $this->fetchRow($select);
        $revision = 1;

        if ($contentRow instanceof Hobo_Db_Table_Row_Content) {
            $revision = ((int) $contentRow->getRevision()) +1;
            unset($contentRow);
        }

        return $revision;
    }
}