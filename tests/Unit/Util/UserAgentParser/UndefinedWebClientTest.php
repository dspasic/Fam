<?php
namespace Fam\Util\UserAgentParser;

use PHPUnit\Framework\TestCase;

class UndefinedWebClientTest extends TestCase
{
    /**
     * @var UndefinedWebClient
     */
    private $subject;

    protected function setUp()
    {
        parent::setUp();

        $this->subject = new UndefinedWebClient();
    }

    /**
     * @test
     */
    public function match_WithInvalidValue()
    {
        $this->assertFalse($this->subject->match(
            "User-Agent: Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10.5; de; rv:1.9.2.12) Gecko/20101026 Firefox/3.6.12"
        ));
    }

    /**
     * @test
     */
    public function getName_IsEqualsFirefox()
    {
        $this->assertEquals("undefined", $this->subject->getName());
    }
}
