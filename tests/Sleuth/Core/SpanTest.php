<?php

namespace Sleuth\Core;

class SpanTest extends \PHPUnit_Framework_TestCase
{

    public function test_span_make_should_create_span_object()
    {
        $span = Span::create();
        $this->assertInstanceOf(Span::class, $span);
    }
}