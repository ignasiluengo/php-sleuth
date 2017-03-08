<?php
/**
 * Created by PhpStorm.
 * User: ignasiluengo
 * Date: 7/3/17
 * Time: 16:48
 */

namespace Sleuth\Core\Sampler;


use Sleuth\Core\Sampler;
use Sleuth\Core\Span;
use Sleuth\Core\SpanAccessor;

/**
 * {@link Sampler} that traces only if there is already some tracing going on.
 *
 * Class IsTracingSampler
 * @package Sleuth\Core\Sampler
 */
class IsTracingSampler implements Sampler
{
    /**
     * @var SpanAccessor
     */
    private $accessor;

    /**
     * @param SpanAccessor $accessor
     */
    public function __construct(SpanAccessor $accessor)
    {
        $this->accessor = $accessor;
    }

    /**
     * @param Span $span
     * @return mixed
     */
    public function isSampled(Span $span)
    {
        return $this->accessor->isTracing();
    }
}