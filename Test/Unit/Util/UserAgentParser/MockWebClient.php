<?php
require_once __DIR__ . "/../../../../Fam/Util/UserAgentParser/AbstractWebClient.php";

class Fam_Util_UserAgentParser_MockWebClient extends \Fam\Util\UserAgentParser\AbstractWebClient
{
    public $patterns = array();
    public $name = "";

    protected function  getPatterns()
    {
        return $this->patterns;
    }

    public function  getName()
    {
        return $this->name;
    }
}
