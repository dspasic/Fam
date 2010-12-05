<?php

require_once __DIR__ . "/../../../Fam/Util/WebBrowserDetector.php";

class Fam_Util_WebBrowserDetectorTest extends PHPUnit_Framework_TestCase
{
    private $originHttpUserAgent = null;

    protected function setUp()
    {
        $this->originHttpUserAgent = isset($_ENV["HTTP_USER_AGENT"]) ? $_ENV["HTTP_USER_AGENT"] : null;
    }

    protected function tearDown()
    {
        $_ENV["HTTP_USER_AGENT"] = $this->originHttpUserAgent;
    }
}