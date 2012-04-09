<?php

class Hobo_Db_Table_Content extends Hobo_Db_Table
{
    protected $_name = 'hobo_content';
    protected $_rowClass = 'Hobo_Db_Table_Row_Content';

    public function selectLatest($data)
    {
        $select = $this->select()
                       ->where('isGlobal = ?', ($data->isGlobal === true || $data->isGlobal == 'true') ? 1 : 0)
                       ->where('routeName = ?', $data->routeName)
                       ->where('handle = ?', $data->handle)
                       ->order('id desc')
                       ->limit(1);

        return $this->fetchRow($select);
    }
}