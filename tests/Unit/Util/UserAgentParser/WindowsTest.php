<?php

use Fam\Util\UserAgentParser\Windows;

class Fam_Util_UserAgentParser_WindowsTest extends \PHPUnit\Framework\TestCase
{
    /**
     *
     * @var Windows
     */
    private $subject;

    protected function setUp()
    {
        parent::setUp();

        $this->subject = new Windows();
    }

    /**
     * @test
     * @dataProvider userAgentOsDataProvider
     */
    public function match_WithValidValue($userAgent)
    {
        $this->assertTrue($this->subject->match($userAgent));
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
    public function getName_returnsWindows()
    {
        $this->assertEquals("windows", $this->subject->getName());
    }

    public function userAgentOsDataProvider()
    {
        return [
            [
                "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)",
            ],

            [
                "Mozilla/4.0 (compatible; MSIE 6.0; win98 5.0)",
            ],

            [
                "Mozilla/4.0 (compatible; MSIE 6.0; win95 5.0)",
            ],

            [
                "Mozilla/4.0 (compatible; MSIE 6.0; win 9x 5.0)",
            ],
        ];
    }
}
