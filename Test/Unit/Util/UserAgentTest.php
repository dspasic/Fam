<?php

require_once __DIR__ . "/../../../Fam/Util/UserAgent.php";
require_once __DIR__ . "/../../../Fam/Util/UserAgentParser/OperatingSystem.php";
require_once __DIR__ . "/../../../Fam/Util/UserAgentParser/WebClient.php";

use \Fam\Util\UserAgent;

class Fam_Util_UserAgentTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function os_delegatesReturnValue()
    {
        $operatingSystem = $this->createOperatingSystemMock();

        $operatingSystem->expects($this->once())
            ->method('getName')
            ->will($this->returnValue(__METHOD__));

        $userAgent = new UserAgent($operatingSystem, $this->createWebClientMock());
        $this->assertEquals(__METHOD__, $userAgent->os());
    }

    /**
     * @test
     */
    public function isOs_delegatesArgumentToOperatingSystem()
    {
        $operatingSystem = $this->createOperatingSystemMock();

        $operatingSystem->expects($this->once())
            ->method('equals')
            ->with($this->equalTo(__METHOD__));

        $userAgent = new UserAgent($operatingSystem, $this->createWebClientMock());
        $userAgent->isOs(__METHOD__);
    }

    /**
     * @test
     */
    public function isOs_delegatesReturnValue()
    {
        $operatingSystem = $this->createOperatingSystemMock();

        $operatingSystem->expects($this->once())
            ->method('equals')
            ->will($this->returnValue(true));

        $userAgent = new UserAgent($operatingSystem, $this->createWebClientMock());
        $this->assertTrue($userAgent->isOs(__METHOD__));
    }

    /**
     * @test
     */
    public function webClient_delegatesReturnValue()
    {
        $webClient = $this->createWebClientMock();

        $webClient->expects($this->once())
            ->method('getName')
            ->will($this->returnValue(__METHOD__));

        $userAgent = new UserAgent($this->createOperatingSystemMock(), $webClient);
        $this->assertEquals(__METHOD__, $userAgent->webClient());
    }

    /**
     * @test
     */
    public function isWebClient_delegatesArgument()
    {
        $webClient = $this->createWebClientMock();

        $webClient->expects($this->once())
            ->method('isNameEquals')
            ->with($this->equalTo(__METHOD__));

        $userAgent = new UserAgent($this->createOperatingSystemMock(), $webClient);
        $userAgent->isWebClient(__METHOD__);
    }

    /**
     * @test
     */
    public function isWebClient_delegatesReturnValue()
    {
        $webClient = $this->createWebClientMock();

        $webClient->expects($this->once())
            ->method('isNameEquals')
            ->will($this->returnValue(true));

        $userAgent = new UserAgent($this->createOperatingSystemMock(), $webClient);
        $this->assertTrue($userAgent->isWebClient(__METHOD__));
    }

    /**
     * @test
     */
    public function webClientVersion_delegatesReturnValue()
    {
        $webClient = $this->createWebClientMock();

        $webClient->expects($this->once())
            ->method('getVersion')
            ->will($this->returnValue(__METHOD__));

        $userAgent = new UserAgent($this->createOperatingSystemMock(), $webClient);
        $this->assertEquals(__METHOD__, $userAgent->webClientVersion());
    }

    /**
     * @test
     */
    public function isWebClientVersion_delegatesArgument()
    {
        $webClient = $this->createWebClientMock();

        $webClient->expects($this->once())
            ->method('isVersionEquals')
            ->with($this->equalTo(__METHOD__));

        $userAgent = new UserAgent($this->createOperatingSystemMock(), $webClient);
        $userAgent->isWebClientVersion(__METHOD__);
    }

    /**
     * @test
     */
    public function isWebClientVersion_delegatesReturnValue()
    {
        $webClient = $this->createWebClientMock();

        $webClient->expects($this->once())
            ->method('isVersionEquals')
            ->will($this->returnValue(true));

        $userAgent = new UserAgent($this->createOperatingSystemMock(), $webClient);
        $this->assertTrue($userAgent->isWebClientVersion(__METHOD__));
    }

    /**
     * @test
     */
    public function isWebClientVersionBetween_delegatesArguments()
    {
        $webClient = $this->createWebClientMock();

        $webClient->expects($this->once())
            ->method('isVersionBetween')
            ->with($this->equalTo(__CLASS__), $this->equalTo(__FUNCTION__));

        $userAgent = new UserAgent($this->createOperatingSystemMock(), $webClient);
        $userAgent->isWebClientVersionBetween(__CLASS__, __FUNCTION__);
    }

    /**
     * @test
     */
    public function isWebClientVersionBetween_delegatesReturnValue()
    {
        $webClient = $this->createWebClientMock();

        $webClient->expects($this->once())
            ->method('isVersionBetween')
            ->will($this->returnValue(true));

        $userAgent = new UserAgent($this->createOperatingSystemMock(), $webClient);
        $this->assertTrue($userAgent->isWebClientVersionBetween(__CLASS__, __FUNCTION__));
    }

    /**
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    private function createOperatingSystemMock()
    {
        return $this->getMock(
        	'Fam\Util\UserAgentParser\OperatingSystem',
            array(),
            array(),
            '',
            false
        );
    }

    /**
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    private function createWebClientMock()
    {
        return $this->getMock(
        	'Fam\Util\UserAgentParser\WebClient',
            array(),
            array(),
            '',
            false
        );
    }
}