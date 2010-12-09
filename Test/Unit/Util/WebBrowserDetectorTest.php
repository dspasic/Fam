<?php

require_once __DIR__ . "/../../../Fam/Util/WebBrowserDetector.php";

class Fam_Util_WebBrowserDetectorTest extends PHPUnit_Framework_TestCase
{
    private $originHttpUserAgent = null;

    protected function setUp()
    {
        $this->originHttpUserAgent = false !== getenv("HTTP_USER_AGENT") ? getenv("HTTP_USER_AGENT") : null;
    }

    protected function tearDown()
    {
        \Fam\Util\WebBrowserDetector::restoreInstance();
        putenv("HTTP_USER_AGENT=" . $this->originHttpUserAgent);
    }
    
    /**
     * @test
     * @dataProvider userAgentOsDataProvider
     */
    public function detectOs($userAgent, $expectedOs)
    {
        putenv("HTTP_USER_AGENT=" . $userAgent);
        $this->assertEquals($expectedOs, \Fam\Util\WebBrowserDetector::os());
    }
    
    /**
     * @test
     * @dataProvider userAgentWebClientDataProvider
     */
    public function detectWebClient($userAgent, $expectedWebClient)
    {
        putenv("HTTP_USER_AGENT=" . $userAgent);
        $this->assertEquals($expectedWebClient, \Fam\Util\WebBrowserDetector::webClient());
    }
    
    /**
     * @test
     */
    public function webClientVersion_withUndefinedUserAgent()
    {
        putenv("HTTP_USER_AGENT=Lynx/2.8.4rel.1 libwww-FM/2.14 SSL-MM/1.4.1 OpenSSL/0.9.6c");
        $this->assertEquals(\Fam\Util\WebBrowserDetector::WEBCLIENT_UNDEFINED, \Fam\Util\WebBrowserDetector::webClientVersion());
    }

    /**
     * @test
     */
    public function webClientVersion_withMSIE_60()
    {
        putenv("HTTP_USER_AGENT=Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0");
        $this->assertEquals(6.0, \Fam\Util\WebBrowserDetector::webClientVersion());
    }
    

    public function userAgentOsDataProvider()
    {
        return array(
            array(
            	"Lynx/2.8.4rel.1 libwww-FM/2.14 SSL-MM/1.4.1 OpenSSL/0.9.6c", 
                \Fam\Util\WebBrowserDetector::OS_UNDEFINED,   
            ),
            
            array(
                "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)",
                \Fam\Util\WebBrowserDetector::OS_WIN,
            ),
            
            array(
                "Mozilla/4.0 (compatible; MSIE 6.0; win98 5.0)",
                \Fam\Util\WebBrowserDetector::OS_WIN,
            ),
            
            array(
                "Mozilla/4.0 (compatible; MSIE 6.0; win95 5.0)",
                \Fam\Util\WebBrowserDetector::OS_WIN,
            ),
            
            array(
                "Mozilla/4.0 (compatible; MSIE 6.0; win 9x 5.0)",
                \Fam\Util\WebBrowserDetector::OS_WIN,
            ),
            
            array(
                "Mozilla/5.0 (Mac_PowerPC; U; PPC Mac OS X; en) AppleWebKit/125.2 (KHTML, like Gecko) Safari/125.8",
                \Fam\Util\WebBrowserDetector::OS_MAC,
            ),
            
            array(
                "Mozilla/5.0 (Macintosh; U; PPC Mac OS X; en) AppleWebKit/125.2 (KHTML, like Gecko) Safari/125.8",
                \Fam\Util\WebBrowserDetector::OS_MAC,
            ),
            
            array(
                "Mozilla/5.0 (Mac OS X; U; PPC Mac OS X; en) AppleWebKit/125.2 (KHTML, like Gecko) Safari/125.8",
                \Fam\Util\WebBrowserDetector::OS_MAC,
            ),
            
            array(
                "Mozilla/5.0 (compatible; Konqueror/3.2; Linux 2.6.2) (KHTML, like Gecko)",
                \Fam\Util\WebBrowserDetector::OS_UNIX,
            ),
            
            array(
                "Mozilla/5.0 (compatible; Konqueror/3.2; FreeBSD 2.6) (KHTML, like Gecko)",
                \Fam\Util\WebBrowserDetector::OS_UNIX,
            ),

            array(
                "Mozilla/5.0 (compatible; Konqueror/3.2; NetBSD 2.6) (KHTML, like Gecko)",
                \Fam\Util\WebBrowserDetector::OS_UNIX,
            ),

            array(
                "Mozilla/5.0 (compatible; Konqueror/3.2; IRIX 2.6) (KHTML, like Gecko)",
                \Fam\Util\WebBrowserDetector::OS_UNIX,
            ),
            
            array(
                "Mozilla/5.0 (compatible; Konqueror/3.2; SunOS 2.6) (KHTML, like Gecko)",
                \Fam\Util\WebBrowserDetector::OS_UNIX,
            ),
            
            array(
                "Mozilla/5.0 (compatible; Konqueror/3.2; Unix 2.6) (KHTML, like Gecko)",
                \Fam\Util\WebBrowserDetector::OS_UNIX,
            ),
        );
    }
    
    public function userAgentWebClientDataProvider()
    {
        return array(
            array(
                "Lynx/2.8.4rel.1 libwww-FM/2.14 SSL-MM/1.4.1 OpenSSL/0.9.6c", 
                \Fam\Util\WebBrowserDetector::WEBCLIENT_UNDEFINED,   
            ),
            
            array(
                "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)",
                \Fam\Util\WebBrowserDetector::WEBCLIENT_IE,
            ),
            
            array(
                "User-Agent: Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10.5; de; rv:1.9.2.12) Gecko/20101026 Firefox/3.6.12",
                \Fam\Util\WebBrowserDetector::WEBCLIENT_FF,
            ),
            
            array(
                "Mozilla/5.0 (Windows; U; Windows NT 6.1; zh-HK) AppleWebKit/533.18.1 (KHTML, like Gecko) Version/5.0.2 Safari/533.18.5",
                \Fam\Util\WebBrowserDetector::WEBCLIENT_SAFARI,
            ),
            
            array(
                "Opera/9.99 (Windows NT 5.1; U; pl) Presto/9.9.9",
                \Fam\Util\WebBrowserDetector::WEBCLIENT_OP,
            ),
            
            array(
                "Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.7.5) Gecko/20060127 Netscape/8.1",
                \Fam\Util\WebBrowserDetector::WEBCLIENT_NS,
            ),
        );
    }
}