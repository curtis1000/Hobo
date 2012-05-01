<?php

class Hobo_Controller_Action_Helper_Installer extends Zend_Controller_Action_Helper_Abstract
{
    const NO_DATABASE = false;
    const NO_TABLE = false;
    public static $Tables = array('hobo_content');

    /**
     * Is hobo installed?
     * @return bool
     */
    public function isInstalled()
    {
        return $this->hasTables();
    }

    /**
     * Does the database have the necessary tables?
     * @return bool
     */
    public function hasTables() {
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            if ($db == null) {
                return self::NO_DATABASE;
            }
        } catch(Exception $e) {
            return self::NO_DATABASE;
        }

        foreach (self::$Tables as $tableName) {
            try {
                $result = $db->describeTable($tableName); //throws exception
                if (empty($result)) {
                    return self::NO_TABLE;
                }
            } catch (Exception $e) {
                return self::NO_TABLE;
            }
        }
        // else, tables exist
        return true;
    }

    public function install()
    {
        $contentTable = new Hobo_Db_Table_Content();
        $contentTable->create();
    }
}