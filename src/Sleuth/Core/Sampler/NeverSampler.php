<?php

namespace Sleuth\Core\Sampler;


use Sleuth\Core\Sampler;
use Sleuth\Core\Span;

class NeverSampler implements Sampler
{

    public function isSampled(Span $span)
    {
        return false;
    }
}