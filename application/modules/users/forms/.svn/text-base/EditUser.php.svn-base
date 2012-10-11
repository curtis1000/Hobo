<?php
/**
 * Bear Users Module
 *
 * @category Bear
 * @package Module
 * @subpackage Users
 * @author Konr Ness <kness@sierra-bravo.com>
 */

/**
 * Edit user form
 *
 * @category Bear
 * @package Module
 * @subpackage Users
 * @author Konr Ness <kness@sierra-bravo.com>
 * @version $Id$
 */
class Users_Form_EditUser extends Bear_Form
{
    /**
     * Base URL
     * 
     * @var string
     */
    protected $_baseUrl;

    /**
     * User row to edit
     * 
     * @var Users_Model_DbTable_Users_Row
     */
    protected $_user;

    /**
     * Get the base URL
     *
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->_baseUrl;
    }

    /**
     * Get the Doctrine base user model
     *
     * @return Users_Model_DbTable_Users_Row
     * @throws Zend_Form_Exception
     */
    public function getUser()
    {
        if (!$this->_user) {
            throw new Zend_Form_Exception("No user set");
        }

        return $this->_user;
    }

    /**
     * Initialize the form
     * 
     * @return void
     */
    public function init()
    {
        $this->addElement(
            $this->createElement("text", "emailAddress")
                 ->setLabel("Email Address")
                 ->setRequired(true)
                 ->addValidator("NotEmpty", true, array("messages" => "Cannot be empty"))
                 ->addValidator("StringLength", true, array(0, 100, "messages" => "Cannot be more than %max% characters long"))
                 ->addValidator("SimpleEmailAddress", true, array("messages" => "'%value%' is not a valid email address"))
                 ->addValidator("Db_NoRecordExists", true, array('users', "email", $this->_getEmailExclude(), "messages" => "'%value%' is already registered"))
                 ->setOrder(1)
        );

        $this->addElement(
            $this->createElement("text", "firstName")
                 ->setLabel("First Name")
                 ->setRequired(true)
                 ->addValidator("NotEmpty", true, array("messages" => "Cannot be empty"))
                 ->addValidator("StringLength", true, array(0, 100, "messages" => "Cannot be more than %max% characters long"))
                 ->setOrder(2)
        );

        $this->addElement(
            $this->createElement("text", "lastName")
                 ->setLabel("Last Name")
                 ->setRequired(true)
                 ->addValidator("NotEmpty", true, array("messages" => "Cannot be empty"))
                 ->addValidator("StringLength", true, array(0, 100, "messages" => "Cannot be more than %max% characters long"))
                 ->setOrder(3)
        );

        $this->addElement(
            $this->createElement("select", "role")
                 ->setLabel("Role")
                 ->setRequired(true)
                 ->addMultiOptions(Users_Model_DbTable_Users::$roles)
                 ->setOrder(4)
        );


        $this->addElement(
            $this->createElement("select", "status")
                 ->setLabel("Status")
                 ->setRequired(true)
                 ->addMultiOptions(Users_Model_DbTable_Users::$statuses)
                 ->setOrder(5)
        );

        $this->addElement(
            $this->createElement("submit", "submit")
                 ->setLabel("Save User")
                 ->setIgnore(true)
                 ->setOrder(99)
        );
        
        $this->setElementFilters(array('StringTrim', 'StripTags'));
        
    }

    /**
     * Set the base URL
     *
     * @param string $baseUrl Base URL
     * @return Users_Form_EditUser
     */
    public function setBaseUrl($baseUrl)
    {
        $this->_baseUrl = $baseUrl;

        return $this;
    }

    /**
     * Set the Doctrine base users model
     *
     * @param Users_Model_DbTable_Users_Row $user User
     * @return Users_Form_EditUser
     */
    public function setUser(Users_Model_DbTable_Users_Row $user)
    {
        $this->_user = $user;
        return $this;
    }

    /**
     * Get the email exclude for the base user
     *
     * @return array
     */
    protected function _getEmailExclude()
    {
        if (!$this->getUser()->id) {
            return null;
        }

        return array(
            "field" => "email",
            "value" => $this->getUser()->email
        );
    }

}