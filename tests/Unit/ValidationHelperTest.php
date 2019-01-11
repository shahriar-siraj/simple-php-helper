<?php

namespace Tests\Unit;

use Tests\TestCase;
use Trollweb\ValidationHelper;

class ValidationHelperTest extends TestCase
{
    public function test_it_validates_urls()
    {
        $helper = new ValidationHelper;

        $this->assertTrue($helper->url("trollweb.no"));
        $this->assertTrue($helper->url("trollweb.no/"));
        $this->assertTrue($helper->url("trollweb.no:8888"));
        $this->assertTrue($helper->url("http://trollweb.no"));
        $this->assertTrue($helper->url("http://trollweb.no:8888"));
        $this->assertTrue($helper->url("https://trollweb.no/"));
        $this->assertTrue($helper->url("https://trollweb.no/om/om-trollweb/"));
        $this->assertTrue($helper->url("https://trollweb.no/?foo=bar"));
        $this->assertTrue($helper->url("http://192.168.0.1/"));
        $this->assertTrue($helper->url("http://trøllwæb.no/"));

        $this->assertFalse($helper->url("localhost"));
        $this->assertFalse($helper->url("trollweb"));
        $this->assertFalse($helper->url("trollweb:8888"));
        $this->assertFalse($helper->url("foo bar"));
    }

    public function test_it_validates_emails()
    {
        $helper = new ValidationHelper;

        $this->assertTrue($helper->email("joachim@trollweb.no"));
        $this->assertTrue($helper->email("joachim.martinsen@trollweb.no"));
        $this->assertTrue($helper->email("joachim.martinsen+foo@trollweb.no"));

        $this->assertFalse($helper->email("trollweb"));
        $this->assertFalse($helper->email("joachim@trollweb"));
        $this->assertFalse($helper->email("joachim@"));
        $this->assertFalse($helper->email("@trollweb"));
    }

    public function test_it_validates_ip_addresses()
    {
        $helper = new ValidationHelper;

        $this->assertTrue($helper->ip("127.0.0.1"));
        $this->assertTrue($helper->ip("192.168.0.1"));

        $this->assertFalse($helper->ip("256.0.0.1"));
        $this->assertFalse($helper->ip("192.168.0"));
        $this->assertFalse($helper->ip("localhost"));
        $this->assertFalse($helper->ip("trollweb.no"));
        $this->assertFalse($helper->ip("one.two.three.four"));
    }

    public function test_it_validates_input_based_on_given_rules()
    {
        $helper = new ValidationHelper;

        $rules = ["min" => 3];

        $this->assertTrue($helper->validate("abc", $rules));
        $this->assertTrue($helper->validate("ab cd", $rules));
        $this->assertTrue($helper->validate(3, $rules));
        $this->assertTrue($helper->validate(3.1, $rules));
        $this->assertTrue($helper->validate(123, $rules));

        $this->assertFalse($helper->validate("ab", $rules));
        $this->assertFalse($helper->validate(2, $rules));

        $rules = ["max" => 5];

        $this->assertTrue($helper->validate("6", $rules));
        $this->assertTrue($helper->validate("abc", $rules));
        $this->assertTrue($helper->validate(5, $rules));

        $this->assertFalse($helper->validate(5.1, $rules));
        $this->assertFalse($helper->validate("123456", $rules));

        $rules = ["type" => "string"];

        $this->assertTrue($helper->validate("6", $rules));
        $this->assertTrue($helper->validate("foo", $rules));
        $this->assertFalse($helper->validate(1.1, $rules));
        $this->assertFalse($helper->validate(null, $rules));
        $this->assertFalse($helper->validate(true, $rules));

        $rules = ["type" => "integer"];

        $this->assertTrue($helper->validate(66, $rules));
        $this->assertTrue($helper->validate(0, $rules));

        $this->assertFalse($helper->validate(1.1, $rules));
        $this->assertFalse($helper->validate(null, $rules));
        $this->assertFalse($helper->validate(true, $rules));

        $rules = ["type" => "bool"];

        $this->assertTrue($helper->validate(true, $rules));
        $this->assertTrue($helper->validate(false, $rules));

        $this->assertFalse($helper->validate(null, $rules));
        $this->assertFalse($helper->validate(0, $rules));
        $this->assertFalse($helper->validate(1, $rules));
        $this->assertFalse($helper->validate("true", $rules));

        $rules = ["type" => "array"];

        $this->assertTrue($helper->validate(["foo"], $rules));
        $this->assertTrue($helper->validate([], $rules));

        $this->assertFalse($helper->validate(null, $rules));
        $this->assertFalse($helper->validate("foo", $rules));
        $this->assertFalse($helper->validate(1, $rules));

        $rules = ["type" => "object"];

        $this->assertTrue($helper->validate(new \DateTime, $rules));

        $this->assertFalse($helper->validate(null, $rules));
        $this->assertFalse($helper->validate("DateTime", $rules));
        $this->assertFalse($helper->validate(1, $rules));

        $rules = ["type" => "string|integer|float"];

        $this->assertTrue($helper->validate("foo", $rules));
        $this->assertTrue($helper->validate(12, $rules));
        $this->assertTrue($helper->validate(99.99, $rules));

        $rules = ["contains" => "bar"];

        $this->assertTrue($helper->validate("bar", $rules));
        $this->assertTrue($helper->validate("foobar", $rules));
        $this->assertTrue($helper->validate("foobarbaz", $rules));
        $this->assertTrue($helper->validate("foo bar baz", $rules));

        $this->assertFalse($helper->validate("foobaz", $rules));
        $this->assertFalse($helper->validate(true, $rules));

        $rules = ["min" => 4, "max" => 7, "contains" => "bar"];

        $this->assertTrue($helper->validate("foobar", $rules));
        $this->assertTrue($helper->validate("bar12", $rules));

        $this->assertFalse($helper->validate("bar", $rules));
        $this->assertFalse($helper->validate("foobarbaz", $rules));
        $this->assertFalse($helper->validate("foobaz", $rules));
    }
}
