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
 * Represents a InternetExplorer
 *
 * @package    Util
 * @subpackage UserAgentParser
 * @author     Dejan Spasic <spasic.dejan@yahoo.de>
 * @version    @@PACKAGE_VERSION@@
 */
class InternetExplorer extends AbstractWebClient
{
    public function getName(): string
    {
        return 'internetexplorer';
    }

    protected function getPatterns(): array
    {
        return [
            '#MSIE ([a-zA-Z0-9.]+)#i',
        ];
    }
}
