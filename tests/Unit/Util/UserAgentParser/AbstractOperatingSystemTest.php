<?php

use Fam\Util\UserAgentParser\OperatingSystem;

require_once __DIR__ . "/MockOperatingSystem.php";

class Fam_Util_UserAgentParser_AbstractOperatingSystemTest extends \PHPUnit\Framework\TestCase
{
    /**
     *
     * @var Fam_Util_UserAgentParser_MockOperatingSystem
     */
    private $subject;

    protected function setUp()
    {
        parent::setUp();

        $this->subject = new Fam_Util_UserAgentParser_MockOperatingSystem();
    }

    /**
     * @test
     */
    public function match_WithValidValue()
    {
        $this->subject->patterns = array(
            '/FreeBSD/i',
        );
        $this->assertTrue($this->subject->match(
            "Mozilla/5.0 (compatible; Konqueror/3.2; FreeBSD 2.6) (KHTML, like Gecko)"
        ));
    }

    /**
     * @test
     */
    public function match_WithInvalidValue()
    {
        $this->subject->patterns = array(
            '/FreeBSD/i',
        );
        $this->assertFalse($this->subject->match("Lynx/2.8.4rel.1 libwww-FM/2.14 SSL-MM/1.4.1 OpenSSL/0.9.6c"));
    }

    /**
     * @test
     */
    public function equals_WithValidStringValue()
    {
        $this->subject->name = "unix";
        $this->assertTrue($this->subject->equals("unix"));
    }

    /**
     * @test
     */
    public function equals_WithInvalidStringValue()
    {
        $this->subject->name = "unix";
        $this->assertFalse($this->subject->equals("windows"));
    }

    /**
     * @test
     */
    public function equals_WithValidOperatingSystem()
    {
        $this->subject->name = 'unix';
        $op = $this->getMockBuilder(OperatingSystem::class)->getMock();

        $op->expects($this->once())
            ->method('getName')
            ->will($this->returnValue('unix'));

        $this->assertTrue($this->subject->equals($op));
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function equals_ThorwsInvalidArgumentException()
    {
      $this->subject->equals(new \stdClass());
    }
}
