<?php

namespace Fam\Util;

use PHPUnit\Framework\TestCase;

class UserAgentParserTest extends TestCase
{
    /**
     * @var UserAgentParser
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
        $this->assertCount(3, $subject->getOperatingSystems());
    }

    /**
     * @test
     * @depends getOperatingSystems
     */
    public function addOperatingSystem()
    {
        $this->assertCount(0, $this->subject->getOperatingSystems());

        $op = $this->getMockBuilder(UserAgentParser\OperatingSystem::class)->getMock();
        $this->subject->addOperatingSystem($op);

        $this->assertCount(1, $this->subject->getOperatingSystems());
    }

    /**
     * @test
     * @depends addOperatingSystem
     */
    public function removeOperatingSystem()
    {
        $op = $this->getMockBuilder(UserAgentParser\OperatingSystem::class)->getMock();

        $this->subject->addOperatingSystem($op);
        $this->assertCount(1, $this->subject->getOperatingSystems());

        $this->subject->removeOperatingSystem($op);
        $this->assertCount(0, $this->subject->getOperatingSystems());
    }

    /**
     * @test
     * @depends addOperatingSystem
     */
    public function removeOperatingSystemByClassName()
    {
        $op = $this->getMockBuilder(UserAgentParser\OperatingSystem::class)->getMock();

        $this->subject->addOperatingSystem($op);
        $this->assertCount(1, $this->subject->getOperatingSystems());

        $this->subject->removeOperatingSystemByClassName(get_class($op));
        $this->assertCount(0, $this->subject->getOperatingSystems());
    }

    /**
     * @test
     */
    public function setGetUndefinedOperatingSystem()
    {
        $op = $this->getMockBuilder(UserAgentParser\OperatingSystem::class)->getMock();
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
        $op = $this->getMockBuilder(UserAgentParser\OperatingSystem::class)->getMock();
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
        $op = $this->getMockBuilder(UserAgentParser\OperatingSystem::class)->getMock();
        $op->expects($this->once())
            ->method('match')
            ->will($this->returnValue(false));
        $this->subject->addOperatingSystem($op);

        $undefinedOp = $this->getMockBuilder(UserAgentParser\OperatingSystem::class)->getMock();
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
        $this->assertCount(4, $subject->getWebClients());
    }

    /**
     * @test
     * @depends getWebClients
     */
    public function addWebClient()
    {
        $this->assertCount(0, $this->subject->getWebClients());

        $wc = $this->getMockBuilder(UserAgentParser\WebClient::class)->getMock();
        $this->subject->addWebClient($wc);

        $this->assertCount(1, $this->subject->getWebClients());
    }

    /**
     * @test
     * @depends addWebClient
     */
    public function removeWebClient()
    {
        $wc = $this->getMockBuilder(UserAgentParser\WebClient::class)->getMock();

        $this->subject->addWebClient($wc);
        $this->assertCount(1, $this->subject->getWebClients());

        $this->subject->removeWebClient($wc);
        $this->assertCount(0, $this->subject->getWebClients());
    }

    /**
     * @test
     * @depends addWebClient
     */
    public function removeWebClientByClassName()
    {
        $wc = $this->getMockBuilder(UserAgentParser\WebClient::class)->getMock();

        $this->subject->addWebClient($wc);
        $this->assertCount(1, $this->subject->getWebClients());

        $this->subject->removeWebClientByClassName(get_class($wc));
        $this->assertCount(0, $this->subject->getWebClients());
    }

    /**
     * @test
     */
    public function setGetUndefinedWebClient()
    {
        $wc = $this->getMockBuilder(UserAgentParser\WebClient::class)->getMock();
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
        $wc = $this->getMockBuilder(UserAgentParser\WebClient::class)->getMock();
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
        $wc = $this->getMockBuilder(UserAgentParser\WebClient::class)->getMock();
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
