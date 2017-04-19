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
 * Reproduce a macintosh
 *
 * @package    Util
 * @subpackage UserAgentParser
 * @author     Dejan Spasic <spasic.dejan@yahoo.de>
 * @version    @@PACKAGE_VERSION@@
 */
class Macintosh extends AbstractOperatingSystem
{
    protected function getPatterns(): array
    {
        return [
            '/Mac_PowerPC/i',
            '/Mac OS X/i',
            '/Macintosh/i',
        ];
    }

    public function getName(): string
    {
        return 'macintosh';
    }
}
