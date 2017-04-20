<?php
namespace Fam\Util\UserAgentParser;

class MockOperatingSystem extends AbstractOperatingSystem
{
    public $patterns = [];
    public $name = '';

    public function getPatterns(): array
    {
        return $this->patterns;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
