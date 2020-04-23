<?php

namespace Newteng\FormatDate\Tests;


use Newteng\FormatDate\Exceptions\InvalidArgumentException;
use Newteng\FormatDate\Exceptions\InvalidValueException;
use Newteng\FormatDate\FormatDateToStr;
use PHPUnit\Framework\TestCase;

class FormatDateToStrTest extends TestCase
{
    public function testTransform()
    {
        $format = new FormatDateToStr();
        $this->assertSame('刚刚', $format->transform(time() - 1, 'timestamp'));
        $this->assertSame('1 分钟前', $format->transform(time() - 61, 'timestamp'));
        $this->assertSame('60 分钟前', $format->transform('-1 hours'));
        $this->assertSame('2019-05-20 10:30', $format->transform('2019-05-20 10:30'));
    }

    public function testTransformWithInvalidType()
    {
        $format = new FormatDateToStr();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid type value(timestamp/time_string): foo');

        $format->transform(time(), 'foo');

        $this->fail('Failed to assert transform throw exception with invalid argument.');
    }

    public function testTransformWithInvalidTimestampValue()
    {
        $format = new FormatDateToStr();

        $this->expectException(InvalidValueException::class);
        $this->expectExceptionMessage('Invalid timestamp value: bar');

        $format->transform('bar');

        $this->fail('Failed to assert transform throw exception with invalid timestamp value.');
    }
}