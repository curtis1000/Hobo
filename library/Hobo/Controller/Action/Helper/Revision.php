<?php

class Hobo_Controller_Action_Helper_Revision extends Zend_Controller_Action_Helper_Abstract
{
    /**
     * What should the next revision number be for the given arguments?
     */
    public function getNext($routeName, $handle, $isGlobal)
    {   
        $contentTable = new Hobo_Db_Table_Content();
        
        $select = $contentTable->select()
                               ->where('isGlobal = ?', $isGlobal)
                               ->where('handle = ?', $handle)
                               ->order('revision desc')
                               ->limit(1);
        if (! $isGlobal) {
            $select->where('routeName = ?', $routeName);
        }

        $contentRow = $contentTable->fetchRow($select);
        
        $revision = 1;
        
        if ($contentRow instanceof Hobo_Db_Table_Row_Content) {
            $revision = ((int) $contentRow->getRevision()) +1;
            unset($contentRow);
        }
        
        return $revision;
    }
}