<?php

class Hobo_Db_Table_Content extends Hobo_Db_Table
{
    protected $_name = 'hobo_content';
    protected $_rowClass = 'Hobo_Db_Table_Row_Content';

    public function create()
    {
        $this->getAdapter()->query("
              CREATE TABLE IF NOT EXISTS `hobo_content` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `isGlobal` tinyint(4) NOT NULL DEFAULT '0',
              `routeName` varchar(128) DEFAULT NULL,
              `handle` varchar(255) NOT NULL,
              `content` text,
              `revision` int(11) NOT NULL,
              `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`),
              KEY `revision` (`revision`)
            ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
        ");
    }

    /**
     * @param $params
     * @return null|Zend_Db_Table_Row_Abstract
     */
    public function selectLatest($params)
    {
        $select = $this->select()
                       ->where('isGlobal = ?', $params['isGlobal'])
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