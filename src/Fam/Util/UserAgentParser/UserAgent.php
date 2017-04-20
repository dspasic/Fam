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
 * Represents a user agent
 *
 * @package    Util
 * @subpackage UserAgentParser
 * @author     Dejan Spasic <spasic.dejan@yahoo.de>
 * @version    @@PACKAGE_VERSION@@
 */
class UserAgent
{
    /**
     * @var OperatingSystem
     */
    private $operatingSystem;

    /**
     * @var WebClient
     */
    private $webClient;

    public function __construct(OperatingSystem $operatingSystem, WebClient $webClient)
    {
        $this->operatingSystem = $operatingSystem;
        $this->webClient = $webClient;
    }

    public function os(): string
    {
        return $this->operatingSystem->getName();
    }

    /**
     * @param  string|OperatingSystem $operatingSystem
     * @return bool
     */
    public function isOs($operatingSystem): bool
    {
        return $this->operatingSystem->equals($operatingSystem);
    }

    public function webClient(): string
    {
        return $this->webClient->getName();
    }

    /**
     * @param  string|WebClient $webClient
     * @return boolean
     */
    public function isWebClient($webClient): bool
    {
        return $this->webClient->isNameEquals($webClient);
    }

    public function webClientVersion(): string
    {
        return $this->webClient->getVersion();
    }

    public function isWebClientVersion(string $webClientVersion): bool
    {
        return $this->webClient->isVersionEquals($webClientVersion);
    }

    public function isWebClientVersionBetween(string $lowerVersion, string $greaterVersion): bool
    {
        return $this->webClient->isVersionBetween($lowerVersion, $greaterVersion);
    }
}
