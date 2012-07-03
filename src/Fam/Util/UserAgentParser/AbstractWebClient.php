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

require_once __DIR__ . '/WebClient.php';

/**
 * Base class for webclients
 *
 * @package    Util
 * @subpackage UserAgentParser
 * @author     Dejan Spasic <spasic.dejan@yahoo.de>
 * @version    @@PACKAGE_VERSION@@
 */
abstract class AbstractWebClient implements WebClient
{
    /**
     * @var string
     */
    private $version = "";

    /**
     * @param string $userAgent
     *
     * @return boolean
     */
    public function match($userAgent)
    {
        foreach ($this->getPatterns() as $currentPattern) {
            $matches = array();
            if (preg_match($currentPattern, $userAgent, $matches)) {
                $this->version = $matches[1];
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
     * @param string|Fam\Util\UserAgentParser\WebClient $webClient
     *
     * @return boolean
     *
     * @throws \InvalidArgumentException
     */
    public function isNameEquals($webClient)
    {
        $name = '';
        if ($webClient instanceof \Fam\Util\UserAgentParser\WebClient) {
            $name = $webClient->getName();
        }
        else if (is_string($webClient)) {
            $name = $webClient;
        }
        else {
            throw new \InvalidArgumentException(
                'Invalid argument given. Excpected argument are string or \Fam\Util\UserAgentParser\WebClient'
            );
        }

        return strtoupper($this->getName()) === strtoupper($name);
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param string $version
     *
     * @return boolean
     */
    public function isVersionEquals($version)
    {
        return $this->getVersion() === $version;
    }

    /**
     * @param string $lowerVersion
     * @param string $greaterVersion
     *
     * @return boolean
     */
    public function isVersionBetween($lowerVersion, $greaterVersion)
    {
        return version_compare($lowerVersion, $this->getVersion(), "<=")
            && version_compare($greaterVersion, $this->getVersion(), ">=");
    }
}
