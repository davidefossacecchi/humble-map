<?php
require_once(__DIR__.'/DummyStaticHolder.php');
use PHPUnit\Framework\TestCase;
use Dfossacecchi\HumbleMap\Map;
use Dfossacecchi\HumbleMap\Exceptions\NotFoundMapException;
class StaticMapHolderTest extends TestCase
{
    public function testMapHolder()
    {
        $map = DummyStaticHolder::getTestDataMap();
        
        $this->assertInstanceOf(Map::class, $map);
    }
    
    public function testException()
    {
        $this->expectException(NotFoundMapException::class);
        
        $map = DummyStaticHolder::getDataTestMap();
    }
}
