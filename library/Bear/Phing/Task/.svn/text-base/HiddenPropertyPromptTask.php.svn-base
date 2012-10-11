<?php

require_once 'phing/tasks/system/PropertyPromptTask.php';

/**
 * Reads input from the HiddenInputHandler.
 *
 * @author    Konr Ness <kness@nerdery.com>
 */
class Bear_Phing_Task_HiddenPropertyPromptTask extends PropertyPromptTask
{
    /**
     * Actual method executed by phing.
     *
     * @throws BuildException
     */
    public function main()
    {
        $oldStyle = shell_exec('stty -g');

        // turn off input echo
        shell_exec('stty -echo');

        parent::main();

        // turn on input echo
        shell_exec('stty ' . $oldStyle);

    }
}
