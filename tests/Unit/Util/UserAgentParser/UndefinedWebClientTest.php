<?php

require_once __DIR__ . "/../../../../src/Fam/Util/UserAgentParser/UndefinedWebClient.php";

class Fam_Util_UserAgentParser_UndefinedWebClientTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \Fam\Util\UserAgentParser\UndefinedWebClient
     */
    private $subject;

    protected function setUp()
    {
        parent::setUp();

        $this->subject = new \Fam\Util\UserAgentParser\UndefinedWebClient();
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