<?php
require_once __DIR__ . "/../../../../src/Fam/Util/UserAgentParser/AbstractOperatingSystem.php";

class Fam_Util_UserAgentParser_MockOperatingSystem extends \Fam\Util\UserAgentParser\AbstractOperatingSystem
{
    public $patterns = array();
    public $name;

    public function getPatterns()
    {
        return $this->patterns;
    }

    public function getName()
    {
        return $this->name;
    }
}
