<?php

namespace Sleuth\Core\Sampler;

use Sleuth\Core\Sampler;
use Sleuth\Core\Span;

class AlwaysSampler implements Sampler
{
    public function isSampled(Span $span)
    {
        return true;
    }
}