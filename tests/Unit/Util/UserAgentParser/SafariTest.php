<?php
namespace Fam\Util\UserAgentParser;

use PHPUnit\Framework\TestCase;

class SafariTest extends TestCase
{
    /**
     * @var Firefox
     */
    private $subject;

    protected function setUp()
    {
        parent::setUp();

        $this->subject = new \Fam\Util\UserAgentParser\Safari();
    }

    /**
     * @test
     */
    public function match_WithValidValue()
    {
        $this->assertTrue($this->subject->match(
            "Mozilla/5.0 (Windows; U; Windows NT 6.1; zh-HK) AppleWebKit/533.18.1 (KHTML, like Gecko) Version/5.0.2 Safari/533.18.5"
        ));
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
        $this->assertEquals('safari', $this->subject->getName());
    }
}
