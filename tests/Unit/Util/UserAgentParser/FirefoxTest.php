<?php
namespace Fam\Util\UserAgentParser;

use PHPUnit\Framework\TestCase;

class FirefoxTest extends TestCase
{
    /**
     * @var Firefox
     */
    private $subject;

    protected function setUp()
    {
        parent::setUp();

        $this->subject = new Firefox();
    }

    /**
     * @test
     */
    public function match_WithValidValue()
    {
        $this->assertTrue($this->subject->match(
            "User-Agent: Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10.5; de; rv:1.9.2.12) Gecko/20101026 Firefox/3.6.12"
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
        $this->assertEquals('firefox', $this->subject->getName());
    }
}
