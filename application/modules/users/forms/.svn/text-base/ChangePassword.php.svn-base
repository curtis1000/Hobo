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
 * Change password form
 *
 * @category Bear
 * @package Module
 * @subpackage Users
 * @author Konr Ness <kness@sierra-bravo.com>
 * @version $Id$
 */
class Users_Form_ChangePassword extends Bear_Form
{

    /**
     * Initialize the form
     */
    public function init()
    {
        $this->addElement(
            $this->createElement("password", "password")
                 ->setLabel("New Password")
                 ->setRequired(true)
                 ->addValidator("NotEmpty", true, array("messages" => "Cannot be empty"))
                 ->addValidator("CompareFields", true, array("confirmPassword", "messages" => "The password does not match the confirmation password"))
                 ->addValidator("StringLength", true, array(6, "messages" => "Cannot be less than %min% characters long"))

        );

        $this->addElement(
            $this->createElement("password", "confirmPassword")
                 ->setLabel("Confirm Password")
                 ->setRequired(true)
                 ->setAutoInsertNotEmptyValidator(false)

        );
        
        $this->addElement(
            $this->createElement("submit", "submit")
                 ->setLabel("Change Password")
                 ->setIgnore(true)
        );
                        
    }

}