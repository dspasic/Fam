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
    public function match(string $userAgent): bool;

    public function getName(): string;

    /**
     * @param string|WebClient $webClient
     *
     * @return boolean
     */
    public function isNameEquals($webClient): bool;

    public function getVersion(): string;

    public function isVersionEquals(string $version): bool;

    public function isVersionBetween(string $lowerVersion, string $greaterVersion): bool;
}
