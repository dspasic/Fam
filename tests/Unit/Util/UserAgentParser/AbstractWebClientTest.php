<?php

require_once __DIR__ . "/MockWebClient.php";

class Fam_Util_UserAgentParser_AbstractWebClientTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Fam_Util_UserAgentParser_MockWebClient
     */
    private $subject;

    protected function setUp()
    {
        parent::setUp();

        $this->subject = new Fam_Util_UserAgentParser_MockWebClient();
    }

    /**
     * @test
     */
    public function match_WithValidValue()
    {
        $this->subject->patterns = array(
            '#Opera[ /]([a-zA-Z0-9.]+)#i',
        );
        $this->assertTrue($this->subject->match(
            "Opera/9.99 (Windows NT 5.1; U; pl) Presto/9.9.9"
        ));
    }

    /**
     * @test
     */
    public function match_WithInvalidValue()
    {
        $this->subject->patterns = array(
            '#Opera[ /]([a-zA-Z0-9.]+)#i',
        );
        $this->assertFalse($this->subject->match("Lynx/2.8.4rel.1 libwww-FM/2.14 SSL-MM/1.4.1 OpenSSL/0.9.6c"));
    }

    /**
     * @test
     */
    public function isNameEquals_WithVaildStringValue()
    {
        $this->subject->name = "firefox";
        $this->assertTrue($this->subject->isNameEquals("firefox"));
    }

    /**
     * @test
     */
    public function equals_WithValidOperatingSystem()
    {
        $this->subject->name = "firefox";
        $op = $this->getMock('Fam\Util\UserAgentParser\WebClient', array(), array(), '', false);

        $op->expects($this->once())
            ->method("getName")
            ->will($this->returnValue("firefox"));

        $this->assertTrue($this->subject->isNameEquals($op));
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function equals_ThorwsInvalidArgumentException()
    {
        $this->subject->isNameEquals(new \stdClass());
    }

    /**
     * @test
     * @depends match_WithValidValue
     */
    public function getVersion()
    {
        $this->subject->patterns = array(
            '#Opera[ /]([a-zA-Z0-9.]+)#i',
        );
        $this->subject->match("Opera/9.99 (Windows NT 5.1; U; pl) Presto/9.9.9");
        $this->assertEquals("9.99", $this->subject->getVersion());
    }

    /**
     * @test
     * @depends getVersion
     */
    public function isVersionEquals_WithValidVersion()
    {
        $this->subject->patterns = array(
            '#Opera[ /]([a-zA-Z0-9.]+)#i',
        );
        $this->subject->match("Opera/9.99 (Windows NT 5.1; U; pl) Presto/9.9.9");
        $this->assertTrue($this->subject->isVersionEquals("9.99"));
    }

    /**
     * @test
     * @depends getVersion
     */
    public function isVersionEquals_WithInvalidVersion()
    {
        $this->subject->patterns = array(
            '#Opera[ /]([a-zA-Z0-9.]+)#i',
        );
        $this->subject->match("Opera/9.99 (Windows NT 5.1; U; pl) Presto/9.9.9");
        $this->assertFalse($this->subject->isVersionEquals(__CLASS__));
    }

    /**
     * @test
     * @depends getVersion
     */
    public function isVersionBetween_WithValidVersions()
    {
        $this->subject->patterns = array(
            '#Opera[ /]([a-zA-Z0-9.]+)#i',
        );
        $this->subject->match("Opera/9.99 (Windows NT 5.1; U; pl) Presto/9.9.9");
        $this->assertTrue($this->subject->isVersionBetween('9', '10'));
    }

    /**
     * @test
     * @depends getVersion
     */
    public function isVersionBetween_WithInvalidVersions()
    {
        $this->subject->patterns = array(
            '#Opera[ /]([a-zA-Z0-9.]+)#i',
        );
        $this->subject->match("Opera/9.99 (Windows NT 5.1; U; pl) Presto/9.9.9");
        $this->assertFalse($this->subject->isVersionBetween('10', '12'));
    }
}
