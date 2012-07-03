<?php

require_once __DIR__ . "/../../../../src/Fam/Util/UserAgentParser/UndefinedOperatingSystem.php";

class Fam_Util_UserAgentParser_UndefinedOperatingSystemTest extends PHPUnit_Framework_TestCase
{
    /**
     *
     * @var \Fam\Util\UserAgentParser\Windows
     */
    private $subject;

    protected function setUp()
    {
        parent::setUp();

        $this->subject = new \Fam\Util\UserAgentParser\UndefinedOperatingSystem();
    }

    /**
     * @test
     */
    public function match_AlwaysRreturnsFalse()
    {
        $this->assertFalse($this->subject->match("Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)"));
    }

    /**
     * @test
     */
    public function getName_returnsUndefined()
    {
        $this->assertEquals("undefined", $this->subject->getName());
    }
}
