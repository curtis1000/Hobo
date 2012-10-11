<?php

class Bear_Auth_Adapter_BlowfishDbTable extends Zend_Auth_Adapter_DbTable
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;

    /**
     * Intentionally no $credentialTreatment parameter
     *
     * @param Zend_Db_Adapter_Abstract $zendDb
     * @param string|Zend_Db_Table_Abstract $tableName
     * @param string $identityColumn
     * @param string $credentialColumn
     */
    public function __construct(Zend_Db_Adapter_Abstract $zendDb = null, $tableName = null,
                                $identityColumn = null, $credentialColumn = null)
    {
        if (! Bear_Crypt_Blowfish::isSupported()) {
            throw new Zend_Auth_Adapter_Exception('Blowfish crypt hashing not supported, unable to use BlowfishDbTable auth adapter');
        }

        if ($tableName instanceof Zend_Db_Table_Abstract) {
            $this->setDbTable($tableName);
            $tableName = $tableName->info(Zend_Db_Table::NAME);
        }

        parent::__construct($zendDb, $tableName, $identityColumn, $credentialColumn);

    }

    protected function _authenticateCreateSelect()
    {
        // get select
        if ($this->getDbTable() instanceof Zend_Db_Table_Abstract) {
            $dbSelect = $this->getDbTable()->select();
        } else {
            $dbSelect = clone $this->getDbSelect();
        }
        $dbSelect->from($this->_tableName)
                 ->where($this->_zendDb->quoteIdentifier($this->_identityColumn, true) . ' = ?', $this->_identity);

        return $dbSelect;
    }

    protected function _authenticateValidateResult($resultIdentity)
    {
        // make sure the result identity has a password set
        if (empty($resultIdentity['password'])) {
            $this->_authenticateResultInfo['code'] = Zend_Auth_Result::FAILURE_UNCATEGORIZED;
            $this->_authenticateResultInfo['messages'][] = 'Identity is missing valid credentials.';
            return $this->_authenticateCreateAuthResult();
        }

        //Check that hash value is correct
        $hash = Bear_Crypt_Blowfish::hash($this->_credential, $resultIdentity['password']);

        $match = ($hash === $resultIdentity['password']);

        if (!$match) {
            $this->_authenticateResultInfo['code'] = Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID;
            $this->_authenticateResultInfo['messages'][] = 'Supplied credential is invalid.';
            return $this->_authenticateCreateAuthResult();
        }

        $this->_resultRow = $resultIdentity;

        $this->_authenticateResultInfo['code'] = Zend_Auth_Result::SUCCESS;
        $this->_authenticateResultInfo['messages'][] = 'Authentication successful.';

        // attempt to load the identity from the Db Table and assert additional
        // authentication validation
        /** @var $dbTableRow Bear_Auth_ValidatableIdentity */
        if ($dbTableRow = $this->_fetchDbTableRow($resultIdentity)) {
            if ($dbTableRow instanceof Bear_Auth_ValidatableIdentity) {

                /** @var $authResult Zend_Auth_Result */
                $authResult = $dbTableRow->validateIdentity();

                // check if the auth result states the auth is invalid
                if ($authResult instanceof Zend_Auth_Result && !$authResult->isValid()) {
                    return $authResult;
                }
            }
        }

        return $this->_authenticateCreateAuthResult();
    }

    /**
     * @param \Zend_Db_Table_Abstract $dbTable
     */
    public function setDbTable($dbTable)
    {
        $this->_dbTable = $dbTable;
    }

    /**
     * @return \Zend_Db_Table_Abstract|null
     */
    public function getDbTable()
    {
        return $this->_dbTable;
    }

    /**
     * Attempt to fetch the identity row from the DbTable.
     *
     * If the DbTable is not set, this will return null.
     *
     * @param string $resultIdentity
     * @return Zend_Db_Table_Row_Abstract|null
     */
    protected function _fetchDbTableRow($resultIdentity)
    {
        if (! $this->getDbTable() instanceof Zend_Db_Table_Abstract) {
            return null;
        }

        $primaryKeyCols = $this->getDbTable()->info(Zend_Db_Table::PRIMARY);

        $where = array();

        foreach ($primaryKeyCols as $primaryKeyCol) {
            $where["$primaryKeyCol = ?"] = $resultIdentity[$primaryKeyCol];
        }

        return $this->getDbTable()->fetchRow($where);
    }
    
}