<?php
/**
 * (c) 2008 Dejan Spasic <spasic.dejan@yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package    Util
 * @author     Dejan Spasic <spasic.dejan@yahoo.de>
 * @version    GIT: $Id:$
 */

namespace Fam\Util;

use Fam\Util\UserAgentParser\OperatingSystem;
use Fam\Util\UserAgentParser\UndefinedOperatingSystem;
use Fam\Util\UserAgentParser\UndefinedWebClient;
use Fam\Util\UserAgentParser\UserAgent;
use Fam\Util\UserAgentParser\WebClient;

/**
 * A lightweight and fast browser detector
 *
 * Sniffs the operating system, web client name and web client version from
 * environment HTTP_USER_AGENT.
 *
 * <code>
 *   $userAgent = UserAgentParser::createInstance()->parseUserAgent($_SERVER['HTTP_USER_AGENT']);
 *
 *   if ($userAgent->isWebClient('firefox')) {
 *       if (UserAgentParser::isWebClientVersionBetween(9.5, 9.6)) {
 *          echo 'firefox between 95 and 96';
 *       }
 *       else if (UserAgentParser::isWebClientVersionBetween(9.2, 9.4)) {
 *          echo 'firefox between 92 and 94';
 *       }
 *   }
 *
 *   if ($userAgent->isOs('macintosh')) {
 *      echo 'Mac';
 *   }
 * </code>
 *
 * @package    Util
 * @author     Dejan Spasic <spasic.dejan@yahoo.de>
 * @version    @@PACKAGE_VERSION@@
 */
class UserAgentParser
{
    /**
     * @var string
     */
    private $userAgent = null;

    /**
     * @var array
     */
    private $operatingSystems = array();

    /**
     * @var array
     */
    private $webClients = array();

    /**
     * @var OperatingSystem
     */
    private $undefinedOperatingSystem;

    /**
     * @var OperatingSystem
     */
    private $undefinedWebClient;

    public function __construct()
    {
        $this->undefinedOperatingSystem = new UndefinedOperatingSystem();
        $this->undefinedWebClient = new UndefinedWebClient();
    }

    public static function createInstance(): self
    {
        $self = new static();
        $self->initializeCommonOperatingSystems();
        $self->initializeCommonWebClients();

        return $self;
    }

    private function initializeCommonOperatingSystems()
    {
        $this->addOperatingSystem(new UserAgentParser\Windows());
        $this->addOperatingSystem(new UserAgentParser\Macintosh());
        $this->addOperatingSystem(new UserAgentParser\Unix());
    }

    private function initializeCommonWebClients()
    {
        $this->addWebClient(new UserAgentParser\Firefox());
        $this->addWebClient(new UserAgentParser\Opera());
        $this->addWebClient(new UserAgentParser\Safari());
        $this->addWebClient(new UserAgentParser\InternetExplorer());
    }

    public function parseUserAgent(string $userAgent): UserAgent
    {
        $this->userAgent = $userAgent;

        return new UserAgent($this->parseOs(), $this->parseWebClient());
    }

    /**
     * @return OperatingSystem
     */
    private function parseOs(): OperatingSystem
    {
        foreach ($this->operatingSystems as $currentOs) {
            if ($currentOs->match($this->userAgent)) {
                return $currentOs;
            }
        }

        return $this->undefinedOperatingSystem;
    }

    private function parseWebClient(): WebClient
    {
        foreach ($this->webClients as $currentWebClient) {
            if ($currentWebClient->match($this->userAgent)) {
                return $currentWebClient;
            }
        }

        return $this->undefinedWebClient;
    }

    public function addOperatingSystem(OperatingSystem $operatingSystem)
    {
        $this->operatingSystems[get_class($operatingSystem)] = $operatingSystem;
    }

    public function removeOperatingSystem(OperatingSystem $operatingSystem)
    {
        $this->removeOperatingSystemByClassName(get_class($operatingSystem));
    }

    public function removeOperatingSystemByClassName(string $operatingSystem)
    {
        unset($this->operatingSystems[$operatingSystem]);
    }

    public function getOperatingSystems(): array
    {
        return $this->operatingSystems;
    }

    public function getUndefinedOperatingSystem(): OperatingSystem
    {
        return $this->undefinedOperatingSystem;
    }

    public function setUndefinedOperatingSystem(OperatingSystem $operatingSystem)
    {
        $this->undefinedOperatingSystem = $operatingSystem;
    }

    public function addWebClient(WebClient $webClient)
    {
        $this->webClients[get_class($webClient)] = $webClient;
    }

    public function removeWebClient(WebClient $webClient)
    {
        $this->removeWebClientByClassName(get_class($webClient));
    }

    public function removeWebClientByClassName(string $webClient)
    {
        unset($this->webClients[$webClient]);
    }

    public function getWebClients(): array
    {
        return $this->webClients;
    }

    public function getUndefinedWebClient(): WebClient
    {
        return $this->undefinedWebClient;
    }

    public function setUndefinedWebClient(WebClient $webClient)
    {
        $this->undefinedWebClient = $webClient;
    }
}
