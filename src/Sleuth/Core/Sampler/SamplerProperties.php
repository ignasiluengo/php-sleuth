<?php
/**
 * Created by PhpStorm.
 * User: ignasiluengo
 * Date: 7/3/17
 * Time: 17:29
 */

namespace Sleuth\Core\Sampler;


class SamplerProperties
{
    /**
     * @var float
     */
    private $percentage = 0.1;

    /**
     * @return float
     */
    public function getPercentage(): float
    {
        return $this->percentage;
    }

    /**
     * @param float $percentage
     */
    public function setPercentage(float $percentage)
    {
        $this->percentage = $percentage;
    }
}