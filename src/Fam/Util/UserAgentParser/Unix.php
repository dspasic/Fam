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

require_once __DIR__ . '/AbstractOperatingSystem.php';

/**
 * Reproduce a unix
 *
 * @package    Util
 * @subpackage UserAgentParser
 * @author     Dejan Spasic <spasic.dejan@yahoo.de>
 * @version    @@PACKAGE_VERSION@@
 */
class Unix extends AbstractOperatingSystem
{
    /**
     * @return array
     */
    protected function getPatterns()
    {
        return array(
            '/Linux/i',
            '/FreeBSD/i',
            '/NetBSD/i',
            '/OpenBSD/i',
            '/IRIX/i',
            '/SunOS/i',
            '/Unix/i',
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'unix';
    }
}