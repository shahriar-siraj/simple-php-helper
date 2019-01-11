<?php

namespace Tests\Unit;

use Tests\TestCase;
use Trollweb\StringHelper;

class StringHelperTest extends TestCase
{
    public function test_it_converts_to_camel_case()
    {
        $helper = new StringHelper;

        $this->assertEquals("fooBar", $helper->camelCase("foo bar"));
        $this->assertEquals("fooBar", $helper->camelCase("foo_bar"));
        $this->assertEquals("fooBar", $helper->camelCase("FooBar"));
        $this->assertEquals("fooBar", $helper->camelCase("FOO BAR"));
        $this->assertEquals("fooBar", $helper->camelCase("foo.bar"));
        $this->assertEquals("fooBarBaz", $helper->camelCase("foo bar baz"));
        $this->assertEquals("foobar", $helper->camelCase("foobar"));
        $this->assertEquals("foobar", $helper->camelCase("FOOBAR"));
    }

    public function test_it_converts_to_snake_case()
    {
        $helper = new StringHelper;

        $this->assertEquals("foo_bar", $helper->snakeCase("foo bar"));
        $this->assertEquals("foo_bar", $helper->snakeCase("foo.bar"));
        $this->assertEquals("foo_bar", $helper->snakeCase("FooBar"));
        $this->assertEquals("foo_bar", $helper->snakeCase("FOO BAR"));
        $this->assertEquals("foo_bar_baz", $helper->snakeCase("foo bar baz"));
        $this->assertEquals("foobar", $helper->snakeCase("foobar"));
    }

    public function test_it_converts_to_url_slug()
    {
        $helper = new StringHelper;

        $this->assertEquals("foo-bar", $helper->urlSlug("foo bar"));
        $this->assertEquals("foo.bar", $helper->urlSlug("foo.bar"));
        $this->assertEquals("foobar", $helper->urlSlug("FooBar"));
        $this->assertEquals("foo-bar", $helper->urlSlug("FOO BAR"));
        $this->assertEquals("foo-bar-baz", $helper->urlSlug("foo bar baz"));
        $this->assertEquals("foo_bar", $helper->urlSlug("foo_bar"));
        $this->assertEquals("foo-bar", $helper->urlSlug("føø bær"));
    }
}
