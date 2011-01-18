<?php

require_once __DIR__ . "/../../../Fam/Util/UserAgentParser.php";

class Fam_Util_UserAgentParserTest extends PHPUnit_Framework_TestCase
{
    private $originHttpUserAgent = null;

    protected function setUp()
    {
        $this->originHttpUserAgent = false !== getenv("HTTP_USER_AGENT") ? getenv("HTTP_USER_AGENT") : null;
    }

    protected function tearDown()
    {
        \Fam\Util\UserAgentParser::restoreInstance();
        putenv("HTTP_USER_AGENT=" . $this->originHttpUserAgent);
    }
    
    /**
     * @test
     * @dataProvider userAgentWebClientDataProvider
     */
    public function detectWebClient($userAgent, $expectedWebClient)
    {
        putenv("HTTP_USER_AGENT=" . $userAgent);
        $this->assertEquals($expectedWebClient, \Fam\Util\UserAgentParser::webClient());
    }
    
    /**
     * @test
     */
    public function webClientVersion_withUndefinedUserAgent()
    {
        putenv("HTTP_USER_AGENT=Lynx/2.8.4rel.1 libwww-FM/2.14 SSL-MM/1.4.1 OpenSSL/0.9.6c");
        $this->assertEquals(\Fam\Util\UserAgentParser::WEBCLIENT_UNDEFINED, \Fam\Util\UserAgentParser::webClientVersion());
    }

    /**
     * @test
     */
    public function webClientVersion_withMSIE_60()
    {
        putenv("HTTP_USER_AGENT=Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0");
        $this->assertEquals(6.0, \Fam\Util\UserAgentParser::webClientVersion());
    }
    
    /**
     * @test
     */
    public function isWebClient()
    {
        putenv("HTTP_USER_AGENT=Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0");
        $this->assertTrue(
            \Fam\Util\UserAgentParser::isWebClient(\Fam\Util\UserAgentParser::WEBCLIENT_IE),
            'Expected web client is IE'
        );
        $this->assertFalse(
            \Fam\Util\UserAgentParser::isWebClient(\Fam\Util\UserAgentParser::WEBCLIENT_FF),
            'Not exptected web client FireFox'
        );
    }
    
    /**
     * @test
     */
    public function isWebClientVersion()
    {
        putenv("HTTP_USER_AGENT=Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0");
        $this->assertTrue(
            \Fam\Util\UserAgentParser::isWebClientVersion('6.0'),
            'Expected matching with version 6.0'
        );
        
        $this->assertFalse(
            \Fam\Util\UserAgentParser::isWebClientVersion('8.0'),
            'Not expected version of 8.0'
        );
    }
    
    /**
     * @test
     */
    public function isWebClientVersionBetween()
    {
        putenv("HTTP_USER_AGENT=Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0");
        $this->assertTrue(
            \Fam\Util\UserAgentParser::isWebClientVersionBetween(4, 7),
            'Expcted a range between 4 and 7'
        );
    }
    
    /**
     * @test
     */
    public function isWebClientVersionBetween_notValidWithLowerThan()
    {
        putenv("HTTP_USER_AGENT=Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0");
        $this->assertFalse(
            \Fam\Util\UserAgentParser::isWebClientVersionBetween(4, 5),
            'Expcted a out of range between 4 and 5'
        );
    }
    
    /**
     * @test
     */
    public function isWebClientVersionBetween_notValidWithGreaterThan()
    {
        putenv("HTTP_USER_AGENT=Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0");
        $this->assertFalse(
            \Fam\Util\UserAgentParser::isWebClientVersionBetween(7, 8),
            'Expcted a out of range between 7 and 8'
        );
    }

    /**
     * @test
     */
    public function getOperatingSystem()
    {
        $this->assertEquals(3, count(\Fam\Util\UserAgentParser::getInstance()->getOperatingSystems()));
    }

    /**
     * @test
     */
    public function addOperatingSystem()
    {
        $this->assertEquals(3, count(\Fam\Util\UserAgentParser::getInstance()->getOperatingSystems()));

        $op = $this->getMock('\Fam\Util\UserAgentParser\OperatingSystem', array(), array(), '', false);
        \Fam\Util\UserAgentParser::getInstance()->addOperatingSystem($op);

        $this->assertEquals(4, count(\Fam\Util\UserAgentParser::getInstance()->getOperatingSystems()));
    }

    /**
     * @test
     */
    public function removeOperatingSystem()
    {
        $op = $this->getMock('\Fam\Util\UserAgentParser\OperatingSystem', array(), array(), '', false);

        \Fam\Util\UserAgentParser::getInstance()->addOperatingSystem($op);
        $this->assertEquals(4, count(\Fam\Util\UserAgentParser::getInstance()->getOperatingSystems()));

        \Fam\Util\UserAgentParser::getInstance()->removeOperatingSystem($op);
        $this->assertEquals(3, count(\Fam\Util\UserAgentParser::getInstance()->getOperatingSystems()));
    }


    /**
     * @test
     */
    public function removeOperatingSystemByClassName()
    {
        $op = $this->getMock('\Fam\Util\UserAgentParser\OperatingSystem', array(), array(), '', false);

        \Fam\Util\UserAgentParser::getInstance()->addOperatingSystem($op);
        $this->assertEquals(4, count(\Fam\Util\UserAgentParser::getInstance()->getOperatingSystems()));

        \Fam\Util\UserAgentParser::getInstance()->removeOperatingSystemByClassName(get_class($op));
        $this->assertEquals(3, count(\Fam\Util\UserAgentParser::getInstance()->getOperatingSystems()));
    }

    /**
     * @test
     */
    public function setGetUndefinedOperatingSystem()
    {
        $op = $this->getMock('\Fam\Util\UserAgentParser\OperatingSystem', array(), array(), '', false);
        \Fam\Util\UserAgentParser::getInstance()->setUndefinedOperatingSystem($op);
        $this->assertSame($op, \Fam\Util\UserAgentParser::getInstance()->getUndefinedOperatingSystem());   
    }

    /**
     * @test
     * @depends removeOperatingSystem
     * @depends addOperatingSystem
     */
    public function detectOs_WithValidOperatingSystem()
    {
        putenv("HTTP_USER_AGENT=Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0");

        $op = $this->getMock('\Fam\Util\UserAgentParser\OperatingSystem', array(), array(), '', false);

        $subject = \Fam\Util\UserAgentParser::getInstance();
        $this->removeAllOperatingSystems($subject);

        $op->expects($this->once())
            ->method('match')
            ->will($this->returnValue(true));

        $op->expects($this->once())
            ->method('getName')
            ->will($this->returnValue(__CLASS__));

        $subject->addOperatingSystem($op);
        $subject->parseUserAgent();

        $this->assertEquals(__CLASS__, \Fam\Util\UserAgentParser::os());
    }

    /**
     * @test
     * @depends removeOperatingSystem
     * @depends addOperatingSystem
     * @depends setGetUndefinedOperatingSystem
     */
    public function detectOs_WithUndefinedOperatingSystem()
    {
        putenv("HTTP_USER_AGENT=Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0");

        $op = $this->getMock('\Fam\Util\UserAgentParser\OperatingSystem', array(), array(), '', false);
        $undefinedOp = $this->getMock('\Fam\Util\UserAgentParser\OperatingSystem', array(), array(), '', false);

        $op->expects($this->once())
            ->method('match')
            ->will($this->returnValue(false));

        $subject = \Fam\Util\UserAgentParser::getInstance();
        $this->removeAllOperatingSystems($subject);
        $subject->addOperatingSystem($op);

        $undefinedOp->expects($this->once())
            ->method('getName')
            ->will($this->returnValue(__CLASS__));

        $subject->setUndefinedOperatingSystem($undefinedOp);

        $subject->parseUserAgent();

        $this->assertEquals(__CLASS__, \Fam\Util\UserAgentParser::os());
    }

    private function removeAllOperatingSystems(\Fam\Util\UserAgentParser $userAgentParser)
    {
        foreach ($userAgentParser->getOperatingSystems() as $currentOs) {
            $userAgentParser->removeOperatingSystem($currentOs);
        }
    }

    /**
     * @test
     */
    public function isOs()
    {
        putenv("HTTP_USER_AGENT=Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0");
        $this->assertTrue(
            \Fam\Util\UserAgentParser::isOs(\Fam\Util\UserAgentParser::OS_WIN),
            'Expected OS is WIN'
        );
        $this->assertFalse(
            \Fam\Util\UserAgentParser::isOs(\Fam\Util\UserAgentParser::OS_UNDEFINED),
            'Not exptected OS undefined'
        );
    }
    
    public function userAgentWebClientDataProvider()
    {
        return array(
            array(
                "Lynx/2.8.4rel.1 libwww-FM/2.14 SSL-MM/1.4.1 OpenSSL/0.9.6c", 
                \Fam\Util\UserAgentParser::WEBCLIENT_UNDEFINED,
            ),
            
            array(
                "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)",
                \Fam\Util\UserAgentParser::WEBCLIENT_IE,
            ),
            
            array(
                "User-Agent: Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10.5; de; rv:1.9.2.12) Gecko/20101026 Firefox/3.6.12",
                \Fam\Util\UserAgentParser::WEBCLIENT_FF,
            ),
            
            array(
                "Mozilla/5.0 (Windows; U; Windows NT 6.1; zh-HK) AppleWebKit/533.18.1 (KHTML, like Gecko) Version/5.0.2 Safari/533.18.5",
                \Fam\Util\UserAgentParser::WEBCLIENT_SAFARI,
            ),
            
            array(
                "Opera/9.99 (Windows NT 5.1; U; pl) Presto/9.9.9",
                \Fam\Util\UserAgentParser::WEBCLIENT_OP,
            ),
        );
    }
}