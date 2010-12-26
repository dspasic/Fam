<?php
/**
 * (c) 2008 Dejan Spasic <sapsic.dejan@yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package    Util
 * @author     Dejan Spasic <spasic.dejan@yahoo.de>
 * @version    GIT: $Id:$
 */

declare(encoding="UTF-8");

namespace Fam\Util;

require_once __DIR__ . '/UserAgentParser/Windows.php';
require_once __DIR__ . '/UserAgentParser/Macintosh.php';
require_once __DIR__ . '/UserAgentParser/Unix.php';
require_once __DIR__ . '/UserAgentParser/UndefinedOperatingSystem.php';

/**
 * A lightweight and fast browser detector
 *
 * Sniffs the operating system, web client name and web client version from
 * envorinment HTTP_USER_AGENT.
 *
 * <code>
 *   if (UserAgentParser::isWebClient(UserAgentParser::WEBCLIENT_OP)) {
 *       if (UserAgentParser::isWebClientVersionBetween(9.5, 9.6)) {
 *           use_stylesheet('brigitte/opera95.css');
 *       }
 *       else if (UserAgentParser::isWebClientVersionBetween(9.2, 9.4)) {
 *           use_stylesheet('brigitte/opera92.css');
 *       }
 *   }
 *   else if (UserAgentParser::isWebClient(UserAgentParser::WEBCLIENT_SAFARI)) {
 *       use_stylesheet('brigitte/safari.css');
 *   }
 *
 *   if (UserAgentParser::isOs(UserAgentParser::OS_MAC)) {
 *       use_stylesheet('brigitte/mac.css');
 *   }
 * </code>
 *
 * @package    Util
 * @author     Dejan Spasic <spasic.dejan@yahoo.de>
 * @version    @@PACKAGE_VERSION@@
 */
class UserAgentParser
{
    /**#@+
     * OS definitions
     *
     * @var string
     */
    const OS_UNDEFINED = 'undefined';
    const OS_WIN       = 'windows';
    const OS_MAC       = 'macintosh';
    const OS_UNIX      = 'unix';
    /**#@-*/

    /**#@+
     * webclient definitions
     *
     * @var string
     */
    const WEBCLIENT_UNDEFINED = null;
    const WEBCLIENT_IE        = 'ie';
    const WEBCLIENT_NS        = 'ns';
    const WEBCLIENT_OP        = 'op';
    const WEBCLIENT_FF        = 'ff';
    const WEBCLIENT_SAFARI    = 'safari';
    /**#@-*/

    /**
     * @var \Fam\Util\UserAgentParser\OperatingSystem
     */
    protected $webClient = null;

    /**
     * @var string
     * @see UserAgentParser::OS_*
     */
    protected $osClient = null;
    
    /**
     * @var int
     */
    protected $webClientVersion = null;

    /**
     * @var string
     */
    private $userAgent = null;
    
    /**
     * a instance of UserAgentParser
     *
     * @var UserAgentParser
     */
    protected static $self = null;

    /**
     * @var array
     */
    private $operatingSystems = array();

    /**
     * @var \Fam\Util\UserAgentParser\OperatingSystem
     */
    private $undefinedOperatingSystem;

    protected function __construct()
    {
        $this->initializeCommonOperatingSystems();
        $this->parseUserAgent();
    }

    private function initializeCommonOperatingSystems()
    {
        $this->operatingSystems = array(
            new UserAgentParser\Windows(),
            new UserAgentParser\Macintosh(),
            new UserAgentParser\Unix(),
        );

        $this->undefinedOperatingSystem = new UserAgentParser\UndefinedOperatingSystem();
    }

    protected function parseUserAgent()
    {
        if (false === ($this->userAgent = getenv("HTTP_USER_AGENT"))) return;

        $this->parseOs();
        $this->parseWebClient();
    }

    protected function parseOs()
    {
        foreach ($this->operatingSystems as $currentOs) {
            if ($currentOs->match($this->userAgent)) {
                $this->osClient = $currentOs;
                return;
            }
        }
        $this->osClient = $this->undefinedOperatingSystem;
    }

    protected function parseWebClient()
    {
        switch (true) {
            case preg_match('#MSIE ([a-zA-Z0-9.]+)#i', $this->userAgent, $matches):
                $this->webClientVersion = (float)$matches[1];
                $this->webClient        = self::WEBCLIENT_IE;
                return;

            case preg_match('#(Firefox|Phoenix|Firebird)/([a-zA-Z0-9.]+)#i', $this->userAgent, $matches):
                $this->webClientVersion = (float)$matches[2];
                $this->webClient        = self::WEBCLIENT_FF;
                return;

            case preg_match('#Safari/([a-zA-Z0-9.]+)#i', $this->userAgent, $matches):
                $this->webClientVersion = (float)$matches[1];
                $this->webClient        = self::WEBCLIENT_SAFARI;
                return;

            case preg_match('#Opera[ /]([a-zA-Z0-9.]+)#i', $this->userAgent, $matches):
                $this->webClientVersion = (float)$matches[1];
                $this->webClient        = self::WEBCLIENT_OP;
                return;

            case preg_match('#Netscape[0-9]?/([a-zA-Z0-9.]+)#i', $this->userAgent, $matches):
                $this->webClientVersion = (float)$matches[1];
                $this->webClient        = self::WEBCLIENT_NS;
                return;

            default:
                $this->webClientVersion = self::WEBCLIENT_UNDEFINED;
                $this->webClient        = self::WEBCLIENT_UNDEFINED;
                return;
        }
    }

    /**
     * override clone to deny the access
     */
    private function __clone() {}
    
    /**
     * return alway the same instance of the class
     *
     * @return UserAgentParser
     */
    public static function getInstance()
    {
        if (false == (self::$self instanceof self)) {
            self::$self = new self();
        }
        return self::$self;
    }

    /**
     * Primary using for unittests
     */
    public static function restoreInstance()
    {
        self::$self = null;
    }

    /**
     * @return string
     */
    public static function os()
    {
        return self::getInstance()->osClient->getName();
    }

    /**
     * @param string $os The OS to compare with
     *
     * @return bool
     */
    public static function isOs($os)
    {
        return self::getInstance()->osClient->equals($os);
    }
    
    /**
     * @return string
     */
    public static function webClient()
    {
        return self::getInstance()->webClient;
    }
    
    /**
     * @param string $wc The webclient to compare with
     *
     * @return bool
     */
    public static function isWebClient($wc)
    {
        return self::webClient() === $wc;
    }

    /**
     * @return float
     */
    public static function webClientVersion()
    {
        return self::getInstance()->webClientVersion;
    }
    
    /**
     * Compares the version between two argugments
     *
     * @param float $version1 The smaller value
     * @param float $version2 The lager value
     *
     * @return bool
     */
    public static function isWebClientVersionBetween($version1, $version2)
    {
        return (self::webClientVersion() >= (float)$version1) && (self::webClientVersion() <= (float)$version2);
    }
    
    /**
     * @param float $v The version
     *
     * @return bool
     */
    public static function isWebClientVersion($v)
    {
        return self::webClientVersion() === (float)$v;
    }

    /**
     * @param \Fam\Util\UserAgentParser\OperatingSystem $operatingSystem
     */
    public function addOperatingSystem(\Fam\Util\UserAgentParser\OperatingSystem $operatingSystem)
    {
        $this->operatingSystems[get_class($operatingSystem)] = $operatingSystem;
    }

    /**
     * @param \Fam\Util\UserAgentParser\OperatingSystem $operatingSystem
     */
    public function removeOperatingSystem(\Fam\Util\UserAgentParser\OperatingSystem $operatingSystem)
    {
        $this->removeOperatingSystemByClassName(get_class($operatingSystem));
    }

    /**
     * @param string $operatingSystem
     */
    public function removeOperatingSystemByClassName($operatingSystem)
    {
        unset($this->operatingSystems[$operatingSystem]);
    }

    /**
     * @return array
     */
    public function getOperatingSystems()
    {
        return $this->operatingSystems;
    }

    /**
     *
     * @return \Fam\Util\UserAgentParser\OperatingSystem
     */
    public function getUndefinedOperatingSystem()
    {
        return $this->undefinedOperatingSystem;
    }

    /**
     * @param \Fam\Util\UserAgentParser\OperatingSystem $operatingSystem
     */
    public function setUndefinedOperatingSystem(\Fam\Util\UserAgentParser\OperatingSystem $operatingSystem)
    {
        $this->undefinedOperatingSystem = $operatingSystem;
    }
}