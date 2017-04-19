<?php
use Fam\Util\UserAgentParser\AbstractOperatingSystem;

class Fam_Util_UserAgentParser_MockOperatingSystem extends AbstractOperatingSystem
{
    public $patterns = [];
    public $name;

    public function getPatterns(): array
    {
        return $this->patterns;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
