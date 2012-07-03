<?php
/**
 * (c) 2008 Dejan Spasic <spasic.dejan@yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package    Util
 * @subpackage UserAgentParser
 * @author     Dejan Spasic <spasic.dejan@yahoo.de>
 * @version    GIT: $Id:$
 */



namespace Fam\Util\UserAgentParser;

/**
 * Reproduce a web client
 *
 * @package    Util
 * @subpackage UserAgentParser
 * @author     Dejan Spasic <spasic.dejan@yahoo.de>
 * @version    @@PACKAGE_VERSION@@
 */
interface WebClient
{
    /**
     * @param string $userAgent
     *
     * @return boolean
     */
    public function match($userAgent);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string|Fam\Util\UserAgentParser\WebClient $webClient
     *
     * @return boolean
     */
    public function isNameEquals($webClient);

    /**
     * @return string
     */
    public function getVersion();

    /**
     * @param string $version
     *
     * @return boolean
     */
    public function isVersionEquals($version);

    /**
     * @param string $lowerVersion
     * @param string $greateVersion
     *
     * @return boolean
     */
    public function isVersionBetween($lowerVersion, $greaterVersion);
}