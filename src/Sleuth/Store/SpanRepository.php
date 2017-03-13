<?php

namespace Sleuth\Store;

use Sleuth\Core\Span;

interface SpanRepository
{
    public function save(Span $span);

    public function delete(Span $span);

    public function deleteTrace(Span $span);

    public function findAllChildren(Span $span);

    public function findAllChildrenRecursively(Span $span);
}