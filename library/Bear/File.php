<?php
/**
 * BEAR
 *
 * @category Bear
 * @package Bear_File
 */

/**
 * Bear file helper
 *
 * @author Justin Hendrickson <justin.hendrickson@sierra-bravo.com>
 * @category Bear
 * @package Bear_File
 */
class Bear_File
{

    /**
     * Determine a files mimetype
     *
     * @param string $filename
     * @param string $magicfile
     * @return string
     * @throws Bear_File_Exception
     */
    static public function getMimeType($filename, $magicfile = null)
    {
        if (class_exists("finfo", false) && ((!empty($magicfile)) or (defined("MAGIC")))) {
            if (!empty($magicfile)) {
                $mime = new finfo(FILEINFO_MIME, $magicfile);
            } else {
                $mime = new finfo(FILEINFO_MIME);
            }

            return $mime->file($filename);
        } elseif (function_exists("mime_content_type") && ini_get("mime_magic.magicfile")) {
            return mime_content_type($filename);
        } else {
            /** Bear_File_Exception */
            require_once "Bear/File/Exception.php";

            throw new Bear_File_Exception(
                "Mimetype of '{$filename}' count not be determined"
            );
        }
    }

}