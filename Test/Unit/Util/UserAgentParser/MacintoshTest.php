<?php

require_once __DIR__ . "/../../../../Fam/Util/UserAgentParser/Macintosh.php";

class Fam_Util_UserAgentParser_MacintoshTest extends PHPUnit_Framework_TestCase
{
    /**
     *
     * @var \Fam\Util\UserAgentParser\Windows
     */
    private $subject;

    protected function setUp()
    {
        parent::setUp();

        $this->subject = new \Fam\Util\UserAgentParser\Macintosh();
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
    public function getName_returnsMacintosh()
    {
        $this->assertEquals("macintosh", $this->subject->getName());
    }

    public function userAgentOsDataProvider()
    {
        return array(
            array(
                "Mozilla/5.0 (Mac_PowerPC; U; PPC Mac OS X; en) AppleWebKit/125.2 (KHTML, like Gecko) Safari/125.8",
            ),

            array(
                "Mozilla/5.0 (Macintosh; U; PPC Mac OS X; en) AppleWebKit/125.2 (KHTML, like Gecko) Safari/125.8",
            ),

            array(
                "Mozilla/5.0 (Mac OS X; U; PPC Mac OS X; en) AppleWebKit/125.2 (KHTML, like Gecko) Safari/125.8",
            ),
        );
    }
    
}
