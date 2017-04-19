<?php
use Fam\Util\UserAgentParser\AbstractWebClient;


class Fam_Util_UserAgentParser_MockWebClient extends AbstractWebClient
{
    public $patterns = array();
    public $name = "";

    protected function  getPatterns(): array
    {
        return $this->patterns;
    }

    public function  getName(): string
    {
        return $this->name;
    }
}
