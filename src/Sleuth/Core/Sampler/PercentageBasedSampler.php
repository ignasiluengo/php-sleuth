<?php

namespace Sleuth\Core\Sampler;

use Sleuth\Core\AtomicInteger;
use Sleuth\Core\Sampler;
use Sleuth\Core\Span;

class PercentageBasedSampler implements Sampler
{
    /**
     * @var AtomicInteger
     */
    private $counter;

    /**
     * @var SamplerProperties
     */
    private $configuration;

    /**
     * @var []bytes
     */
    private $sampleDecisions;

    public function __construct(SamplerProperties $configuration)
    {
        $outOf100 = (int) ($configuration->getPercentage() * 100.0);
        $this->sampleDecisions = self::randomBitSet(100, $outOf100);
        $this->configuration = $configuration;
        $this->counter = new AtomicInteger();
    }

    /**
     * @param Span $currentSpan
     * @return bool|mixed
     */
    public function isSampled(Span $currentSpan = null)
    {
        if ((0 === $this->configuration->getPercentage()) || (null === $currentSpan)) {
            return false;
        }

        if (100 === $this->configuration->getPercentage()) {
            return true;
        }

        $i = $this->counter->getAndIncrement();
        $result = $this->sampleDecisions[$i];
        if (99 === $i) {
            $this->counter->set(0);
        }

        return $result;
    }

    /**
     * @param int $size
     * @param int $cardinality
     * @return array
     */
    public static function randomBitSet(int $size, int $cardinality) : array
    {
        $result = [];
        foreach (range(1, $cardinality) as $it) {
            $result[] =  hex2bin(openssl_random_pseudo_bytes($size));
        }

        return $result;
    }
}