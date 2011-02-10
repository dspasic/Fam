<?php

require_once __DIR__ . "/../../../Fam/Util/UserAgentParser.php";

class Fam_Util_UserAgentParserTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function getOperatingSystems()
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
        $userAgent = $subject->parseUserAgent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0");

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
        $userAgent = $subject->parseUserAgent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0");

        $this->assertEquals(__CLASS__, $userAgent->os());
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
    public function getWebClients()
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
        $userAgent = $subject->parseUserAgent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0");

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

        $subject = $subject = $this->createUserAgentParser();
        $this->removeAllWebClients($subject);

        $wc->expects($this->never())
            ->method('match')
            ->will($this->returnValue(true));

        $wc->expects($this->once())
            ->method('getName')
            ->will($this->returnValue(__CLASS__));

        $subject->setUndefinedWebClient($wc);
        $userAgent = $subject->parseUserAgent("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0");

        $this->assertEquals(__CLASS__, $userAgent->webClient());
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