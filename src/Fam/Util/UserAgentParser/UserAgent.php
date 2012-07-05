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
 * Prepresends a useragent
 *
 * @package    Util
 * @subpackage UserAgentParser
 * @author     Dejan Spasic <spasic.dejan@yahoo.de>
 * @version    @@PACKAGE_VERSION@@
 */
class UserAgent
{
    /**
     * @var \Fam\Util\UserAgentParser\OperatingSystem
     */
    private $operatingSystem;

    /**
     * @var \Fam\Util\UserAgentParser\WebClient
     */
    private $webClient;

    /**
     * @param \Fam\Util\UserAgentParser\OperatingSystem $operatingSystem
     * @param \Fam\Util\UserAgentParser\WebClient       $webClient
     */
    public function __construct(OperatingSystem $operatingSystem, WebClient $webClient)
    {
        $this->operatingSystem = $operatingSystem;
        $this->webClient = $webClient;
    }

    /**
     * @return string
     */
    public function os()
    {
        return $this->operatingSystem->getName();
    }

    /**
     * @param  string|\Fam\Util\UserAgentParser\OperatingSystem $operatingSystem
     * @return boolean
     */
    public function isOs($operatingSystem)
    {
        return $this->operatingSystem->equals($operatingSystem);
    }

    /**
     * @return string
     */
    public function webClient()
    {
        return $this->webClient->getName();
    }

    /**
     * @param  string|\Fam\Util\UserAgentParser\WebClient $webClient
     * @return boolean
     */
    public function isWebClient($webClient)
    {
        return $this->webClient->isNameEquals($webClient);
    }

    /**
     * @return string
     */
    public function webClientVersion()
    {
        return $this->webClient->getVersion();
    }

    /**
     * @param  string  $webClientVersion
     * @return boolean
     */
    public function isWebClientVersion($webClientVersion)
    {
        return $this->webClient->isVersionEquals($webClientVersion);
    }

    /**
     * @param string $lowerVersion
     * @param string $greaterVersion
     *
     * @return boolean
     */
    public function isWebClientVersionBetween($lowerVersion, $greaterVersion)
    {
        return $this->webClient->isVersionBetween($lowerVersion, $greaterVersion);
    }
}
