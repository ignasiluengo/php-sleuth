<?php
/**
 * Created by PhpStorm.
 * User: ignasiluengo
 * Date: 7/3/17
 * Time: 16:46
 */

namespace Sleuth\Core;


interface Sampler
{
    public function isSampled(Span $span);
}