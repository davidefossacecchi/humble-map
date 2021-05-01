<?php

class DummyStaticHolder
{
    use Dfossacecchi\HumbleMap\StaticMapHolder;
    
    protected static $maps_data = [
        'test_data' => [
            'a' => 1,
            'b' => 2
        ]
    ];
}
