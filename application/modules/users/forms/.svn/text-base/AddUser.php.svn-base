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
 * Add user form
 *
 * @category Bear
 * @package Module
 * @subpackage Users
 * @author Konr Ness <kness@sierra-bravo.com>
 * @version $Id$
 */
class Users_Form_AddUser extends Users_Form_EditUser
{

    /**
     * Initialize the form
     * 
     * @return void
     */
    public function init()
    {
        
        parent::init();
        
        $this->addElement(
            $this->createElement("password", "password")
                 ->setLabel("Password")
                 ->setRequired(true)
                 ->addValidator("NotEmpty", true, array("messages" => "Cannot be empty"))
                 ->addValidator("CompareFields", true, array("confirmPassword", "messages" => "The password does not match the confirmation password"))
                 ->addValidator("StringLength", true, array(6, "messages" => "Cannot be less than %min% characters long"))
                 ->setOrder(6)

        );

        $this->addElement(
            $this->createElement("password", "confirmPassword")
                 ->setLabel("Confirm Password")
                 ->setRequired(true)
                 ->setAutoInsertNotEmptyValidator(false)
                 ->setOrder(7)

        );
        
    }

}