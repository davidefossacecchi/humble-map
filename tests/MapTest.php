<?php
use PHPUnit\Framework\TestCase;
use Dfossacecchi\HumbleMap\Map;
class MapTest extends TestCase
{
    public function testInstatiation()
    {
        $this->assertInstanceOf(Map::class, $this->getTestingMap());
    }
    
    public function testIterator()
    {
        $data = $this->getTestingData();
        $keys = array_keys($data);
        $map  = $this->getTestingMap();
        $i = 0;
        
        foreach ($map as $key => $value) {
            $this->assertEquals($keys[$i], $key);
            $this->assertEquals($data[$key], $value);
            $i++;
        }
    }
    
    public function testArrayAccess()
    {
        $map  = $this->getTestingMap();
        $data = $this->getTestingData();
        
        $this->assertEquals($map['b'], $data['b']);
        
        $map['f'] = 6;
        $map['h'] = 9;
        
        $this->assertEquals($map['h'], 9);
        $this->assertEquals($map['f'], 6);
    }
    
    public function testKeys()
    {
        $map  = $this->getTestingMap(); 
        $keys = $map->keys();
        $data = $this->getTestingData();
        $exp  = array_keys($data);
        
        $i = 0;
        
        foreach ($exp as $key) {
            $this->assertEquals($key, $keys[$i]);
            $this->assertEquals($i, $map->keyIndex($key));
            $this->assertEquals($data[$key], $map->valueOf($key));
            $i++;
        }
    }
    
    public function testValues()
    {
        $map     = $this->getTestingMap(); 
        $values  = $map->values();
        $data    = $this->getTestingData();
        $exp     = array_values($data);
        $flipped = array_flip($data);
        
        $i = 0;
        
        foreach ($exp as $val) {
            $this->assertEquals($val, $values[$i]);
            $this->assertEquals($i, $map->valueIndex($val));
            $this->assertEquals($flipped[$val], $map->keyOf($val));
            $i++;
        }
    }
    
    public function testCombine()
    {
        $firstData  = $this->getTestingData();
        $secondData = $this->getTestingData(1);
        
        $firstMap   = $this->getTestingMap();
        $secondMap  = $this->getTestingMap(1);
        
        $combined   = $firstMap->combineWith($secondMap);
        
        $this->assertFalse($firstMap->equals($combined));
        $this->assertFalse($secondMap->equals($combined));
        
        foreach ($firstData as $key => $value) {
            $expect = isset($secondMap[$value])
                    ? $secondMap[$value]
                    : null;
            
            $this->assertEquals($expect, $combined[$key]);
        }
    }
    
    public function testEquals()
    {
        $first  = $this->getTestingMap();
        $second = $this->getTestingMap();
        
        $this->assertTrue($first->equals($second));
        
        $data = $this->getTestingData();
        $data['q'] = '9';
        
        $third = new Map($data);
        $this->assertFalse($third->equals($first));
        $nKeys = $first->keys();
        shuffle($nKeys);
        
        $data = [];
        
        foreach ($nKeys as $key) {
            $data[$key] = $first[$key];
        }
        
        $fourth = new Map($data);
        
        $this->assertTrue($fourth->equals($first));
    }
    
    /**
     * @return array
     */
    protected function getTestingData($i = 0)
    {
        $data = [
            [
                'a' => 3,
                'b' => -1,
                'f' => 5
            ],
            [
                3  => 'k',
                6  => 'd',
                -1 => 'h'
            ]
        ];
        
        return $data[$i];
    }
    
    /**
     * @return Map
     */
    protected function getTestingMap($i = 0)
    {
        return new Map($this->getTestingData($i));
    }
}
