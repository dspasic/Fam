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
    public function detectOs($userAgent, $expected)
    {
        putenv("HTTP_USER_AGENT=" . $userAgent);
        $this->assertEquals($expected, \Fam\Util\WebBrowserDetector::os());
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
                "Mozilla/5.0 (Macintosh; U; PPC Mac OS X; en) AppleWebKit/125.2 (KHTML, like Gecko) Safari/125.8",
                \Fam\Util\WebBrowserDetector::OS_MAC,
            ),
            
            array(
                "Mozilla/5.0 (compatible; Konqueror/3.2; Linux 2.6.2) (KHTML, like Gecko)",
                \Fam\Util\WebBrowserDetector::OS_UNIX,
            ),
        );
    }
}