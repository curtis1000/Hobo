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
 * Forgot password form
 *
 * @category Bear
 * @package Module
 * @subpackage Users
 * @author Konr Ness <kness@sierra-bravo.com>
 * @version $Id$
 */
class Users_Form_ForgotPassword extends Bear_Form
{

    /**
     * Initialize the form
     */
    public function init()
    {
        $this->addElement(
            $this->createElement("text", "emailAddress")
                 ->setLabel("Email Address")
                 ->setRequired(true)
                 ->addValidator("CompareFields", true, array("confirmEmailAddress", "messages" => "The email address does not match the confirmation email address"))
                 ->addValidator("Db_RecordExists", true, array("users", "email", "messages" => "'%value%' does not have an account"))
        );
        
        $this->addElement(
            $this->createElement("text", "confirmEmailAddress")
                 ->setLabel("Confirm Email Address")
                 ->setRequired(true)
                 ->setAutoInsertNotEmptyValidator(false)
        );

        $this->addElement(
            $this->createElement("submit", "submit")
                 ->setLabel("Submit")
                 ->setIgnore(true)
        );
    }

}