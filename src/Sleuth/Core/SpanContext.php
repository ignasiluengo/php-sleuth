<?php
/**
 * Created by PhpStorm.
 * User: ignasiluengo
 * Date: 8/3/17
 * Time: 10:22
 */

namespace Sleuth\Core;

interface SpanContext
{

    /**
     * @return all zero or more baggage items propagating along with the associated Span
     *
     */
    public function getBaggageItems();
}