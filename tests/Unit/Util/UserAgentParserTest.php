<?php

require_once __DIR__ . "/../../../src/Fam/Util/UserAgentParser.php";

use Fam\Util\UserAgentParser;

class Fam_Util_UserAgentParserTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \Fam\Util\UserAgentParser
     */
    private $subject;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new UserAgentParser();
    }

    /**
     * @test
     */
    public function getOperatingSystems()
    {
        $subject = UserAgentParser::createInstance();
        $this->assertEquals(3, count($subject->getOperatingSystems()));
    }

    /**
     * @test
     * @depends getOperatingSystems
     */
    public function addOperatingSystem()
    {
        $this->assertEquals(0, count($this->subject->getOperatingSystems()));

        $op = $this->getMock('\Fam\Util\UserAgentParser\OperatingSystem', array(), array(), '', false);
        $this->subject->addOperatingSystem($op);

        $this->assertEquals(1, count($this->subject->getOperatingSystems()));
    }

    /**
     * @test
     * @depends addOperatingSystem
     */
    public function removeOperatingSystem()
    {
        $op = $this->getMock('\Fam\Util\UserAgentParser\OperatingSystem', array(), array(), '', false);

        $this->subject->addOperatingSystem($op);
        $this->assertEquals(1, count($this->subject->getOperatingSystems()));

        $this->subject->removeOperatingSystem($op);
        $this->assertEquals(0, count($this->subject->getOperatingSystems()));
    }


    /**
     * @test
     * @depends addOperatingSystem
     */
    public function removeOperatingSystemByClassName()
    {
        $op = $this->getMock('\Fam\Util\UserAgentParser\OperatingSystem', array(), array(), '', false);

        $this->subject->addOperatingSystem($op);
        $this->assertEquals(1, count($this->subject->getOperatingSystems()));

        $this->subject->removeOperatingSystemByClassName(get_class($op));
        $this->assertEquals(0, count($this->subject->getOperatingSystems()));
    }

    /**
     * @test
     */
    public function setGetUndefinedOperatingSystem()
    {
        $op = $this->getMock('\Fam\Util\UserAgentParser\OperatingSystem', array(), array(), '', false);
        $this->subject->setUndefinedOperatingSystem($op);
        $this->assertSame($op, $this->subject->getUndefinedOperatingSystem());
    }

    /**
     * @test
     * @depends removeOperatingSystem
     * @depends addOperatingSystem
     */
    public function detectOs_WithValidOperatingSystem()
    {
        $op = $this->getMock('\Fam\Util\UserAgentParser\OperatingSystem', array(), array(), '', false);
        $op->expects($this->once())
            ->method('match')
            ->will($this->returnValue(true));
        $op->expects($this->once())
            ->method('getName')
            ->will($this->returnValue(__CLASS__));
        $this->subject->addOperatingSystem($op);

        $userAgent = $this->subject->parseUserAgent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0");

        $this->assertEquals(__CLASS__, $userAgent->os());
    }

    /**
     * @test
     * @depends removeOperatingSystem
     * @depends addOperatingSystem
     * @depends setGetUndefinedOperatingSystem
     */
    public function detectOs_WithUndefinedOperatingSystem()
    {
        $op = $this->getMock('\Fam\Util\UserAgentParser\OperatingSystem', array(), array(), '', false);
        $op->expects($this->once())
            ->method('match')
            ->will($this->returnValue(false));
        $this->subject->addOperatingSystem($op);

        $undefinedOp = $this->getMock('\Fam\Util\UserAgentParser\OperatingSystem', array(), array(), '', false);
        $undefinedOp->expects($this->once())
            ->method('getName')
            ->will($this->returnValue(__CLASS__));
        $this->subject->setUndefinedOperatingSystem($undefinedOp);

        $userAgent = $this->subject->parseUserAgent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0");

        $this->assertEquals(__CLASS__, $userAgent->os());
    }

    /**
     * @test
     */
    public function getWebClients()
    {
        $subject = UserAgentParser::createInstance();
        $this->assertEquals(4, count($subject->getWebClients()));
    }

    /**
     * @test
     * @depends getWebClients
     */
    public function addWebClient()
    {
        $this->assertEquals(0, count($this->subject->getWebClients()));

        $wc = $this->getMock('\Fam\Util\UserAgentParser\WebClient', array(), array(), '', false);
        $this->subject->addWebClient($wc);

        $this->assertEquals(1, count($this->subject->getWebClients()));
    }

    /**
     * @test
     * @depends addWebClient
     */
    public function removeWebClient()
    {
        $wc = $this->getMock('\Fam\Util\UserAgentParser\WebClient', array(), array(), '', false);

        $this->subject->addWebClient($wc);
        $this->assertEquals(1, count($this->subject->getWebClients()));

        $this->subject->removeWebClient($wc);
        $this->assertEquals(0, count($this->subject->getWebClients()));
    }

    /**
     * @test
     * @depends addWebClient
     */
    public function removeWebClientByClassName()
    {
        $wc = $this->getMock('\Fam\Util\UserAgentParser\WebClient', array(), array(), '', false);

        $this->subject->addWebClient($wc);
        $this->assertEquals(1, count($this->subject->getWebClients()));

        $this->subject->removeWebClientByClassName(get_class($wc));
        $this->assertEquals(0, count($this->subject->getWebClients()));
    }

    /**
     * @test
     */
    public function setGetUndefinedWebClient()
    {
        $wc = $this->getMock('\Fam\Util\UserAgentParser\WebClient', array(), array(), '', false);
        $this->subject->setUndefinedWebClient($wc);
        $this->assertSame($wc, $this->subject->getUndefinedWebClient());
    }

    /**
     * @test
     * @depends removeWebClient
     * @depends addWebClient
     */
    public function detectWebClient_WithValidWebClient()
    {
        $wc = $this->getMock('\Fam\Util\UserAgentParser\WebClient', array(), array(), '', false);
        $wc->expects($this->once())
            ->method('match')
            ->will($this->returnValue(true));
        $wc->expects($this->once())
            ->method('getName')
            ->will($this->returnValue(__CLASS__));

        $this->subject->addWebClient($wc);
        $userAgent = $this->subject->parseUserAgent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0");

        $this->assertEquals(__CLASS__, $userAgent->webClient());
    }

    /**
     * @test
     * @depends removeWebClient
     * @depends setGetUndefinedWebClient
     */
    public function detectWebClient_WithInvalidWebClient()
    {
        $wc = $this->getMock('\Fam\Util\UserAgentParser\WebClient', array(), array(), '', false);
        $wc->expects($this->never())
            ->method('match')
            ->will($this->returnValue(true));
        $wc->expects($this->once())
            ->method('getName')
            ->will($this->returnValue(__CLASS__));

        $this->subject->setUndefinedWebClient($wc);
        $userAgent = $this->subject->parseUserAgent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0");

        $this->assertEquals(__CLASS__, $userAgent->webClient());
    }
}