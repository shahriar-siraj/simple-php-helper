<?php

namespace Tests\Unit;

use Tests\TestCase;
use Trollweb\ArrayHelper;

class ArrayHelperTest extends TestCase
{
    public function test_it_flattens_a_multidimensional_array()
    {
        $helper = new ArrayHelper;
        $array = [
            "foo" => [
                "a" => 1,
                "b" => 2,
                "c" => 3,
            ],
            "bar" => [
                "d" => 4,
                "e" => 5,
                "f" => 6,
            ],
        ];
        $expected = [
            "foo.a" => 1,
            "foo.b" => 2,
            "foo.c" => 3,
            "bar.d" => 4,
            "bar.e" => 5,
            "bar.f" => 6,
        ];

        $flatten = $helper->flatten($array);

        $this->assertEquals($expected, $flatten);
    }

    public function test_it_can_get_a_value_from_a_multidimensional_array_using_dot_notation()
    {
        $helper = new ArrayHelper;
        $array = [
            "foo" => [
                "a" => 1,
                "b" => 2,
                "c" => 3,
            ],
            "bar" => [
                "d" => 4,
                "e" => 5,
                "f" => 6,
            ],
        ];

        $this->assertEquals(1, $helper->get($array, "foo.a"));
        $this->assertEquals(3, $helper->get($array, "foo.c"));
        $this->assertEquals(5, $helper->get($array, "bar.e"));
        $this->assertEquals(5, $helper->get($array, "bar/e")); // Using slash as separator
        $this->assertNull($helper->get($array, "key.doesnt.exist"));
        $this->assertEquals(99, $helper->get($array, "key.doesnt.exist", 99)); // Fallback value
    }

    public function test_it_searches_for_and_deletes_a_value_from_an_array()
    {
        $helper = new ArrayHelper;
        $array = [
            "foo" => "one",
            "bar" => ["two", "three"],
            "baz" => [
                "four" => 4,
                "five" => 5,
            ],
        ];

        $expected = [
            "bar" => ["two", "three"],
            "baz" => [
                "four" => 4,
                "five" => 5,
            ],
        ];
        $this->assertEquals($expected, $helper->removeValue($array, "one"));

        $expected = [
            "foo" => "one",
            "bar" => ["two", "three"],
            "baz" => [
                "four" => 4,
                "five" => 5,
            ],
        ];
        $this->assertEquals($expected, $helper->removeValue($array, "baz.4"));
        $this->assertEquals($expected, $helper->removeValue($array, "baz/4"));
    }

    public function test_it_searches_for_and_deletes_a_key_from_an_array()
    {
        $helper = new ArrayHelper;
        $array = [
            "foo" => "one",
            "bar" => ["two", "three"],
            "baz" => [
                "four" => 4,
                "five" => 5,
            ],
        ];

        $expected = [
            "foo" => "one",
            "baz" => [
                "four" => 4,
                "five" => 5,
            ],
        ];
        $this->assertEquals($expected, $helper->removeKey($array, "bar"));

        $expected = [
            "foo" => "one",
            "bar" => ["two", "three"],
            "baz" => [
                "five" => 5,
            ],
        ];
        $this->assertEquals($expected, $helper->removeKey($array, "baz.four"));
        $this->assertEquals($expected, $helper->removeKey($array, "baz/four"));
    }
}
