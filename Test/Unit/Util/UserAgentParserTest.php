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
        putenv("HTTP_USER_AGENT=" . $this->originHttpUserAgent);
    }

    /**
     * @test
     */
    public function getOperatingSystem()
    {
        $subject = $this->createUserAgentParser();
        $this->assertEquals(3, count($subject->getOperatingSystems()));
    }

    /**
     * @test
     */
    public function addOperatingSystem()
    {
        $subject = $this->createUserAgentParser();
        $this->assertEquals(3, count($subject->getOperatingSystems()));

        $op = $this->getMock('\Fam\Util\UserAgentParser\OperatingSystem', array(), array(), '', false);
        $subject->addOperatingSystem($op);

        $this->assertEquals(4, count($subject->getOperatingSystems()));
    }

    /**
     * @test
     */
    public function removeOperatingSystem()
    {
        $subject = $this->createUserAgentParser();
        $op = $this->getMock('\Fam\Util\UserAgentParser\OperatingSystem', array(), array(), '', false);

        $subject->addOperatingSystem($op);
        $this->assertEquals(4, count( $subject->getOperatingSystems()));

        $subject->removeOperatingSystem($op);
        $this->assertEquals(3, count($subject->getOperatingSystems()));
    }


    /**
     * @test
     */
    public function removeOperatingSystemByClassName()
    {
        $subject = $this->createUserAgentParser();
        $op = $this->getMock('\Fam\Util\UserAgentParser\OperatingSystem', array(), array(), '', false);

        $subject->addOperatingSystem($op);
        $this->assertEquals(4, count($subject->getOperatingSystems()));

        $subject->removeOperatingSystemByClassName(get_class($op));
        $this->assertEquals(3, count($subject->getOperatingSystems()));
    }

    /**
     * @test
     */
    public function setGetUndefinedOperatingSystem()
    {
        $subject = $this->createUserAgentParser();
        $op = $this->getMock('\Fam\Util\UserAgentParser\OperatingSystem', array(), array(), '', false);
        $subject->setUndefinedOperatingSystem($op);
        $this->assertSame($op, $subject->getUndefinedOperatingSystem());   
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

        $subject = $this->createUserAgentParser();
        $this->removeAllOperatingSystems($subject);

        $op->expects($this->once())
            ->method('match')
            ->will($this->returnValue(true));

        $op->expects($this->once())
            ->method('getName')
            ->will($this->returnValue(__CLASS__));

        $subject->addOperatingSystem($op);
        $subject->parseUserAgent();

        $this->assertEquals(__CLASS__, $subject->os());
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

        $subject = $this->createUserAgentParser();
        $this->removeAllOperatingSystems($subject);
        $subject->addOperatingSystem($op);

        $undefinedOp->expects($this->once())
            ->method('getName')
            ->will($this->returnValue(__CLASS__));

        $subject->setUndefinedOperatingSystem($undefinedOp);

        $subject->parseUserAgent();

        $this->assertEquals(__CLASS__, $subject->os());
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
        $subject = $this->createUserAgentParser();
        $this->assertTrue(
            $subject->isOs(\Fam\Util\UserAgentParser::OS_WIN),
            'Expected OS is WIN'
        );
        $this->assertFalse(
            $subject->isOs(\Fam\Util\UserAgentParser::OS_UNDEFINED),
            'Not exptected OS undefined'
        );
    }

    /**
     * @test
     */
    public function getWebClient()
    {
        $subject = $this->createUserAgentParser();
        $this->assertEquals(4, count($subject->getWebClients()));
    }

    /**
     * @test
     */
    public function addWebClient()
    {
        $subject = $this->createUserAgentParser();
        $this->assertEquals(4, count($subject->getWebClients()));

        $wc = $this->getMock('\Fam\Util\UserAgentParser\WebClient', array(), array(), '', false);
        $subject->addWebClient($wc);

        $this->assertEquals(5, count($subject->getWebClients()));
    }

    /**
     * @test
     */
    public function removeWebClient()
    {
        $subject = $this->createUserAgentParser();
        $wc = $this->getMock('\Fam\Util\UserAgentParser\WebClient', array(), array(), '', false);

        $subject->addWebClient($wc);
        $this->assertEquals(5, count($subject->getWebClients()));

        $subject->removeWebClient($wc);
        $this->assertEquals(4, count($subject->getWebClients()));
    }

    /**
     * @test
     */
    public function removeWebClientByClassName()
    {
        $subject = $this->createUserAgentParser();
        $wc = $this->getMock('\Fam\Util\UserAgentParser\WebClient', array(), array(), '', false);

        $subject->addWebClient($wc);
        $this->assertEquals(5, count($subject->getWebClients()));

        $subject->removeWebClientByClassName(get_class($wc));
        $this->assertEquals(4, count($subject->getWebClients()));
    }

    /**
     * @test
     */
    public function setGetUndefinedWebClient()
    {
        $subject = $this->createUserAgentParser();
        $wc = $this->getMock('\Fam\Util\UserAgentParser\WebClient', array(), array(), '', false);
        $subject->setUndefinedWebClient($wc);
        $this->assertSame($wc, $subject->getUndefinedWebClient());
    }

    /**
     * @test
     * @depends removeWebClient
     * @depends addWebClient
     */
    public function detectWebClient_WithValidWebClient()
    {
        putenv("HTTP_USER_AGENT=Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0");

        $wc = $this->getMock('\Fam\Util\UserAgentParser\WebClient', array(), array(), '', false);

        $subject = $subject = $this->createUserAgentParser();
        $this->removeAllWebClients($subject);

        $wc->expects($this->once())
            ->method('match')
            ->will($this->returnValue(true));

        $wc->expects($this->once())
            ->method('getName')
            ->will($this->returnValue(__CLASS__));

        $subject->addWebClient($wc);
        $subject->parseUserAgent();

        $this->assertEquals(__CLASS__, $subject->webClient());
    }

    /**
     * @test
     * @depends removeWebClient
     * @depends setGetUndefinedWebClient
     */
    public function detectWebClient_WithInvalidWebClient()
    {
        putenv("HTTP_USER_AGENT=Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0");

        $wc = $this->getMock('\Fam\Util\UserAgentParser\WebClient', array(), array(), '', false);

        $subject = $subject = $this->createUserAgentParser();
        $this->removeAllWebClients($subject);

        $wc->expects($this->never())
            ->method('match')
            ->will($this->returnValue(true));

        $wc->expects($this->once())
            ->method('getName')
            ->will($this->returnValue(__CLASS__));

        $subject->setUndefinedWebClient($wc);
        $subject->parseUserAgent();

        $this->assertEquals(__CLASS__, $subject->webClient());
    }

    /**
     * @test
     */
    public function webClientVersion()
    {
        putenv("HTTP_USER_AGENT=" . __CLASS__);

        $wc = $this->getMock('\Fam\Util\UserAgentParser\WebClient', array(), array(), '', false);

        $subject = $subject = $this->createUserAgentParser();
        $this->removeAllWebClients($subject);

        $wc->expects($this->once())
            ->method('match')
            ->will($this->returnValue(true));

        $wc->expects($this->once())
            ->method('getVersion')
            ->will($this->returnValue(__CLASS__));

        $subject->addWebClient($wc);
        $subject->parseUserAgent();

        $this->assertEquals(__CLASS__, $subject->webClientVersion());
    }

    /**
     * @test
     */
    public function isWebClientVersion_ExpectValidArgument()
    {
        putenv("HTTP_USER_AGENT=" . __CLASS__);

        $wc = $this->getMock('\Fam\Util\UserAgentParser\WebClient', array(), array(), '', false);

        $subject = $subject = $this->createUserAgentParser();
        $this->removeAllWebClients($subject);

        $wc->expects($this->once())
            ->method('match')
            ->will($this->returnValue(true));

        $wc->expects($this->once())
            ->method('isVersionEquals')
            ->with($this->equalTo(__CLASS__));

        $subject->addWebClient($wc);
        $subject->parseUserAgent();

        $subject->isWebClientVersion(__CLASS__);
    }

    /**
     * @test
     */
    public function isWebClientVersion_WillDelegateReturnValue()
    {
        putenv("HTTP_USER_AGENT=" . __CLASS__);

        $wc = $this->getMock('\Fam\Util\UserAgentParser\WebClient', array(), array(), '', false);

        $subject = $subject = $this->createUserAgentParser();
        $this->removeAllWebClients($subject);

        $wc->expects($this->once())
            ->method('match')
            ->will($this->returnValue(true));

        $wc->expects($this->once())
            ->method('isVersionEquals')
            ->will($this->returnValue(true));

        $subject->addWebClient($wc);
        $subject->parseUserAgent();

        $this->assertTrue($subject->isWebClientVersion(__CLASS__));
    }

    /**
     * @test
     */
    public function isWebClientVersionBetween_WithExpectedAgrument()
    {
        putenv("HTTP_USER_AGENT=" . __CLASS__);
        $wc = $this->getMock('\Fam\Util\UserAgentParser\WebClient', array(), array(), '', false);

        $subject = $subject = $this->createUserAgentParser();
        $this->removeAllWebClients($subject);

        $wc->expects($this->once())
            ->method('match')
            ->will($this->returnValue(true));

        $wc->expects($this->once())
            ->method('isVersionBetween')
            ->with($this->equalTo(__CLASS__), $this->equalTo(__FUNCTION__));

        $subject->addWebClient($wc);
        $subject->parseUserAgent();

        $subject->isWebClientVersionBetween(__CLASS__, __FUNCTION__);
    }

    /**
     * @test
     */
    public function isWebClientVersionBetween_WillDelegateReturnValue()
    {
        putenv("HTTP_USER_AGENT=" . __CLASS__);
        $wc = $this->getMock('\Fam\Util\UserAgentParser\WebClient', array(), array(), '', false);

        $subject = $subject = $this->createUserAgentParser();
        $this->removeAllWebClients($subject);

        $wc->expects($this->once())
            ->method('match')
            ->will($this->returnValue(true));

        $wc->expects($this->once())
            ->method('isVersionBetween')
            ->will($this->returnValue(true));

        $subject->addWebClient($wc);
        $subject->parseUserAgent();

        $this->assertTrue($subject->isWebClientVersionBetween(__CLASS__, __FUNCTION__));
    }

    /**
     * @test
     */
    public function isWebClient_WillDelegateReturnValue()
    {
        putenv("HTTP_USER_AGENT=" . __CLASS__);
        $wc = $this->getMock('\Fam\Util\UserAgentParser\WebClient', array(), array(), '', false);

        $subject = $subject = $this->createUserAgentParser();
        $this->removeAllWebClients($subject);

        $wc->expects($this->once())
            ->method('match')
            ->will($this->returnValue(true));

        $wc->expects($this->once())
            ->method('isNameEquals')
            ->will($this->returnValue(true));

        $subject->addWebClient($wc);
        $subject->parseUserAgent();

        $this->assertTrue($subject->isWebClient(__CLASS__));
    }

    /**
     * @test
     */
    public function isWebClient_WithExpectedAgrument()
    {
        putenv("HTTP_USER_AGENT=" . __CLASS__);
        $wc = $this->getMock('\Fam\Util\UserAgentParser\WebClient', array(), array(), '', false);

        $subject = $subject = $this->createUserAgentParser();
        $this->removeAllWebClients($subject);

        $wc->expects($this->once())
            ->method('match')
            ->will($this->returnValue(true));

        $wc->expects($this->once())
            ->method('isNameEquals')
            ->with($this->equalTo(__CLASS__));

        $subject->addWebClient($wc);
        $subject->parseUserAgent();

        $subject->isWebClient(__CLASS__);
    }

    private function removeAllWebClients(\Fam\Util\UserAgentParser $userAgentParser)
    {
        foreach ($userAgentParser->getWebClients() as $currentWc) {
            $userAgentParser->removeWebClient($currentWc);
        }
    }
    
    /**
     * @return \Fam\Util\UserAgentParser
     */
    private function createUserAgentParser()
    {
        return new \Fam\Util\UserAgentParser();
    }
}