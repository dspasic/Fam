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

/**
 * A lightweight and fast browser detector
 *
 * Sniffs the operating system, web client name and web client version from
 * envorinment HTTP_USER_AGENT.
 *
 * <code>
 *   if (webBrowserDetector::isWebClient(webBrowserDetector::WEBCLIENT_OP)) {
 *       if (webBrowserDetector::isWebClientVersionBetween(9.5, 9.6)) {
 *           use_stylesheet('brigitte/opera95.css');
 *       }
 *       else if (webBrowserDetector::isWebClientVersionBetween(9.2, 9.4)) {
 *           use_stylesheet('brigitte/opera92.css');
 *       }
 *   }
 *   else if (webBrowserDetector::isWebClient(webBrowserDetector::WEBCLIENT_SAFARI)) {
 *       use_stylesheet('brigitte/safari.css');
 *   }
 *
 *   if (webBrowserDetector::isOs(webBrowserDetector::OS_MAC)) {
 *       use_stylesheet('brigitte/mac.css');
 *   }
 * </code>
 *
 * @package    Util
 * @author     Dejan Spasic <spasic.dejan@yahoo.de>
 * @version    @@PACKAGE_VERSION@@
 */
class WebBrowserDetector
{
    /**#@+
     * OS definitions
     *
     * @var string
     */
    const OS_UNDEFINED = null;
    const OS_WIN       = 'win';
    const OS_MAC       = 'mac';
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
     * the current webclient
     *
     * @var string
     * @see webBrowserDetector::WEBCLIENT_*
     */
    protected $webClient = null;
    
    /**
     * the current os
     *
     * @var string
     * @see webBrowserDetector::OS_*
     */
    protected $osClient = null;
    
    /**
     * The webclient version
     *
     * @var int
     */
    protected $webClientVersion = null;
    
    /**
     * a instance of webBrowserDetector
     *
     * @var webBrowserDetector
     */
    protected static $self = null;
    
    /**
     * marks if the detection allready runs
     *
     * @var bool
     */
    protected $detect = false;

    protected function __construct()
    {
        $this->detectUserAgent();
    }

    /**
     * override clone to deny the access
     */
    private function __clone() {}
    
    /**
     * return alway the same instance of the class
     *
     * @return webBrowserDetector
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
        return self::getInstance()->osClient;
    }
    
    /**
     * @return float
     */
    public static function webClientVersion()
    {
        return self::getInstance()->webClientVersion;
    }
    
    /**
     * @return string
     */
    public static function webClient()
    {
        return self::getInstance()->webClient;
    }
    
    /**
     * @param string $os The OS to compare with
     *
     * @return bool
     */
    public static function isOs($os)
    {
        return self::os() === $os;
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

    protected function detectUserAgent()
    {
        if ($this->detect) return;
        if (false === ($ua = getenv("HTTP_USER_AGENT"))) return;
    
        $this->detectOs($ua);
        $this->detectWebClient($ua);
    
        $this->detect = true;
    }
    
    /**
     * @param string $ua The user agent informations
     */
    protected function detectOs($ua)
    {
        switch (true) {
            case preg_match('/windows/i', $ua):
            case preg_match('/win98/i', $ua):
            case preg_match('/win95/i', $ua):
            case preg_match('/win 9x/i', $ua):
                $this->osClient = self::OS_WIN;;
                return;
            
            case preg_match('/Mac_PowerPC/i', $ua):
            case preg_match('/Mac OS X/i', $ua):
            case preg_match('/Macintosh/i', $ua):
                $this->osClient = self::OS_MAC;
                return;
            
            case preg_match('/Linux/i', $ua):
            case preg_match('/FreeBSD/i', $ua):
            case preg_match('/NetBSD/i', $ua):
            case preg_match('/OpenBSD/i', $ua):
            case preg_match('/IRIX/i', $ua):
            case preg_match('/SunOS/i', $ua):
            case preg_match('/Unix/i', $ua):
                $this->osClient = self::OS_UNIX;
                return;
            
            default:
                $this->osClient = self::OS_UNDEFINED;
                return;
        }
    }
    
    /**
     * @param string $ua The user agent informations
     */
    protected function detectWebClient($ua)
    {
        switch (true) {
            case preg_match('#MSIE ([a-zA-Z0-9.]+)#i', $ua, $matches):
                $this->webClientVersion = (float)$matches[1];
                $this->webClient        = self::WEBCLIENT_IE;
                return;
            
            case preg_match('#(Firefox|Phoenix|Firebird)/([a-zA-Z0-9.]+)#i', $ua, $matches):
                $this->webClientVersion = (float)$matches[2];
                $this->webClient        = self::WEBCLIENT_FF;
                return;
            
            case preg_match('#Safari/([a-zA-Z0-9.]+)#i', $ua, $matches):
                $this->webClientVersion = (float)$matches[1];
                $this->webClient        = self::WEBCLIENT_SAFARI;
                return;
            
            case preg_match('#Opera[ /]([a-zA-Z0-9.]+)#i', $ua, $matches):
                $this->webClientVersion = (float)$matches[1];
                $this->webClient        = self::WEBCLIENT_OP;
                return;
            
            case preg_match('#Netscape[0-9]?/([a-zA-Z0-9.]+)#i', $ua, $matches):
                $this->webClientVersion = (float)$matches[1];
                $this->webClient        = self::WEBCLIENT_NS;
                return;
            
            default:
                $this->webClientVersion = self::WEBCLIENT_UNDEFINED;
                $this->webClient        = self::WEBCLIENT_UNDEFINED;
                return;
        }
    }
}