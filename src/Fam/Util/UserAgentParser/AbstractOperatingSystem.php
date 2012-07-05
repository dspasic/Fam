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

require_once __DIR__ . '/OperatingSystem.php';

/**
 * Reproduce a windows
 *
 * @package    Util
 * @subpackage UserAgentParser
 * @author     Dejan Spasic <spasic.dejan@yahoo.de>
 * @version    @@PACKAGE_VERSION@@
 */
abstract class AbstractOperatingSystem implements OperatingSystem
{
    /**
     * @param string $userAgent
     *
     * @return boolean
     */
    public function match($userAgent)
    {
        foreach ($this->getPatterns() as $currentPattern) {
            if (preg_match($currentPattern, $userAgent)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @return array
     */
    abstract protected function getPatterns();

    /**
     * @param string|Fam\Util\UserAgentParser\OperatingSystem $operatingSystem
     *
     * @return boolean
     *
     * @throws \InvalidArgumentException
     */
    public function equals($operatingSystem)
    {
        $name = '';
        if ($operatingSystem instanceof \Fam\Util\UserAgentParser\OperatingSystem) {
            $name = $operatingSystem->getName();
        }
        else if (is_string($operatingSystem)) {
            $name = $operatingSystem;
        }
        else {
            throw new \InvalidArgumentException(
                'Invalid argument given. Excpected argument are string or \Fam\Util\UserAgentParser\OperatingSystem'
            );
        }

        return strtoupper($this->getName()) === strtoupper($name);
    }
}