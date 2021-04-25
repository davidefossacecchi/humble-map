<?php
use PHPUnit\Framework\TestCase;
use Dfossacecchi\HumbleMap\Map;
class MapTest extends TestCase
{
    public function testInstatiation()
    {
        $c = new Map();
        $this->assertInstanceOf(Map::class, $c);
    }
}
