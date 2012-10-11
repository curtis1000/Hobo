<?php
/**
 * Bear
 *
 * @category Bear
 * @package Bear_Version
 */

/**
 * Class to store and retrieve the version of Bear
 *
 * @author Konr Ness <konr.ness@nerdery.com>
 * @category Bear
 * @package Bear_Version
 * @since 1.2.3
 */
final class Bear_Version
{
    /**
     * Zend Framework version identification - see compareVersion()
     */
    const VERSION = '1.4.0';

    /**
     * Compare the specified Bear version string $version
     * with the current Bear_Version::VERSION of Bear.
     *
     * @param  string  $version  A version string (e.g. "0.7.1").
     * @return int           -1 if the $version is older,
     *                           0 if they are the same,
     *                           and +1 if $version is newer.
     *
     */
    public static function compareVersion($version)
    {
        $version = strtolower($version);
        $version = preg_replace('/(\d)pr(\d?)/', '$1a$2', $version);
        return version_compare($version, strtolower(self::VERSION));
    }
}
