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
 * Base class for web clients
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

    public function match(string $userAgent): bool
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

    abstract protected function getPatterns(): array;

    /**
     * @param string|WebClient $webClient
     *
     * @return boolean
     *
     * @throws \InvalidArgumentException
     */
    public function isNameEquals($webClient): bool
    {
        if ($webClient instanceof WebClient) {
            $name = $webClient->getName();
        } elseif (is_string($webClient)) {
            $name = $webClient;
        } else {
            throw new \InvalidArgumentException(
                'Invalid argument given. Excpected argument are string or ' . WebClient::class
            );
        }

        return strtoupper($this->getName()) === strtoupper($name);
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function isVersionEquals(string $version): bool
    {
        return $this->getVersion() === $version;
    }

    /**
     * @param string $lowerVersion
     * @param string $greaterVersion
     *
     * @return boolean
     */
    public function isVersionBetween(string $lowerVersion, string $greaterVersion): bool
    {
        return version_compare($lowerVersion, $this->getVersion(), "<=")
            && version_compare($greaterVersion, $this->getVersion(), ">=");
    }
}
