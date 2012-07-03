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

declare(encoding='UTF-8');

namespace Fam\Util\UserAgentParser;

require_once __DIR__ . '/AbstractOperatingSystem.php';

/**
 * Reproduce a windows
 *
 * @package    Util
 * @subpackage UserAgentParser
 * @author     Dejan Spasic <spasic.dejan@yahoo.de>
 * @version    @@PACKAGE_VERSION@@
 */
class Windows extends AbstractOperatingSystem
{
    /**
     * @var array
     */
    protected function getPatterns()
    {
        return array(
            '/windows/i',
            '/win98/i',
            '/win95/i',
            '/win 9x/i',
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'windows';
    }
}