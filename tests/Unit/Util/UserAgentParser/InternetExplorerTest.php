<?php
namespace Fam\Util\UserAgentParser;

use PHPUnit\Framework\TestCase;

class InternetExplorerTest extends TestCase
{
    /**
     * @var InternetExplorer
     */
    private $subject;

    protected function setUp()
    {
        parent::setUp();

        $this->subject = new InternetExplorer();
    }

    /**
     * @test
     */
    public function match_WithValidValue()
    {
        $this->assertTrue($this->subject->match(
            "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)"
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
        $this->assertEquals('internetexplorer', $this->subject->getName());
    }
}
