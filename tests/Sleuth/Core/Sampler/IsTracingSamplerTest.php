<?php

namespace Sleuth\Core\Sampler;

use Sleuth\Core\Sampler\IsTracingSampler;
use Sleuth\Core\Span;
use Sleuth\Core\SpanAccessor;

/**
 * Class IsTracingSamplerTest
 */
class IsTracingSamplerTest extends \PHPUnit_Framework_TestCase
{
    public function test_should_sample_when_tracing_is_on()
    {
        $span = Span::create();
        $sampler = $this->settingTracingSampler(true);
        $this->assertTrue($sampler->isSampled($span));
    }

    public function test_should_not_sample_when_tracing_is_off()
    {
        $span = Span::create();
        $sampler = $this->settingTracingSampler(false);

        $this->assertFalse($sampler->isSampled($span));
    }

    private function settingTracingSampler(bool $value) : IsTracingSampler
    {
        $spanAccessorMock = \Mockery::mock(SpanAccessor::class);
        $spanAccessorMock->shouldReceive('isTracing')->once()->andReturn($value);

        return new IsTracingSampler($spanAccessorMock);
    }
}