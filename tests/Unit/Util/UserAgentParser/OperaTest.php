<?php
namespace Fam\Util\UserAgentParser;

use PHPUnit\Framework\TestCase;

class OperaTest extends TestCase
{
    /**
     * @var Firefox
     */
    private $subject;

    protected function setUp()
    {
        parent::setUp();

        $this->subject = new \Fam\Util\UserAgentParser\Opera();
    }

    /**
     * @test
     */
    public function match_WithValidValue()
    {
        $this->assertTrue($this->subject->match("Opera/9.99 (Windows NT 5.1; U; pl) Presto/9.9.9"));
    }

    /**
     * @test
     */
    public function match_WithInvalidValue()
    {
        $this->assertFalse($this->subject->match("Lynx/2.8.4rel.1 libwww-FM/2.14 SSL-MM/1.4.1 OpenSSL/0.9.6c"));
    }

    /**
     * @test
     */
    public function getName_IsEqualsFirefox()
    {
        $this->assertEquals('opera', $this->subject->getName());
    }
}
