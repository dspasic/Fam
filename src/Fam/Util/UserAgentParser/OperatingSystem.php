<?php
/**
 * (c) 2008 Dejan Spasic <sapsic.dejan@yahoo.de>
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
 * Reproduce a operating system
 *
 * @package    Util
 * @subpackage UserAgentParser
 * @author     Dejan Spasic <spasic.dejan@yahoo.de>
 * @version    @@PACKAGE_VERSION@@
 */
interface OperatingSystem
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
     * @param string|Fam\Util\UserAgentParser\OperatingSystem $operatingSystem
     * 
     * @return boolean
     */
    public function equals($operatingSystem);
}
