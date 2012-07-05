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

require_once __DIR__ . '/AbstractWebClient.php';

/**
 * Represents a Opera
 *
 * @package    Util
 * @subpackage UserAgentParser
 * @author     Dejan Spasic <spasic.dejan@yahoo.de>
 * @version    @@PACKAGE_VERSION@@
 */
class Opera extends AbstractWebClient
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'opera';
    }

    /**
     * @return array
     */
    protected function getPatterns()
    {
        return array(
            '#Opera[ /]([a-zA-Z0-9.]+)#i',
        );
    }
}

