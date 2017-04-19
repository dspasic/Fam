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
    public function match(string $userAgent): bool
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
    abstract protected function getPatterns(): array;

    /**
     * @param string|OperatingSystem $operatingSystem
     *
     * @return boolean
     *
     * @throws \InvalidArgumentException
     */
    public function equals($operatingSystem): bool
    {
        if ($operatingSystem instanceof OperatingSystem) {
            $name = $operatingSystem->getName();
        } elseif (is_string($operatingSystem)) {
            $name = $operatingSystem;
        } else {
            throw new \InvalidArgumentException(
                'Invalid argument given. Expected argument are string or ' . OperatingSystem::class
            );
        }

        return strtoupper($this->getName()) === strtoupper($name);
    }
}
