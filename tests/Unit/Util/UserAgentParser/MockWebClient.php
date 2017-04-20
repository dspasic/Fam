<?php
namespace Fam\Util\UserAgentParser;

class MockWebClient extends AbstractWebClient
{
    public $patterns = array();
    public $name = '';

    protected function getPatterns(): array
    {
        return $this->patterns;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
