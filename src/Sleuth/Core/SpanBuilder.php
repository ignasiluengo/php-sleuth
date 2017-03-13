<?php

namespace Sleuth\Core;

/**
 * Class SpanBuilder
 * @package Sleuth\Core
 */
class SpanBuilder
{
    /**
     * @var float
     */
    private $begin;

    /**
     * @var float
     */
    private $end;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $traceId;

    /**
     * @var array
     */
    private $parents = [];

    /**
     * @var string
     */
    private $spanId;

    /**
     * @var string
     */
    private $remote;

    /**
     * @var boolean
     */
    private $exportable = true;

    /**
     * @var string
     */
    private $processId;

    /**
     * @var Span
     */
    private $savedSpan;

    /**
     * @var array
     */
    private $logs = [];

    /**
     * @var array
     */
    private $tags = [];

    /**
     * @var array
     */
    private $baggage = [];

    /**
     * @return Span
     */
    public function build(): Span
    {
        return Span::create()->makeFromBuilder($this);
    }

    /**
     * @return float
     */
    public function getBegin(): float
    {
        return $this->begin;
    }

    /**
     * @param float $begin
     * @return SpanBuilder
     */
    public function setBegin(float $begin): SpanBuilder
    {
        $this->begin = $begin;
        return $this;
    }

    /**
     * @return float
     */
    public function getEnd(): float
    {
        return $this->end;
    }

    /**
     * @param float $end
     * @return SpanBuilder
     */
    public function setEnd(float $end): SpanBuilder
    {
        $this->end = $end;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return SpanBuilder
     */
    public function setName(string $name): SpanBuilder
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getTraceId(): string
    {
        return $this->traceId;
    }

    /**
     * @param string $traceId
     * @return SpanBuilder
     */
    public function setTraceId(string $traceId): SpanBuilder
    {
        $this->traceId = $traceId;
        return $this;
    }

    /**
     * @return array
     */
    public function getParents(): array
    {
        return $this->parents;
    }

    /**
     * @param array $parents
     * @return SpanBuilder
     */
    public function setParents(array $parents): SpanBuilder
    {
        $this->parents = $parents;
        return $this;
    }

    /**
     * @return string
     */
    public function getSpanId(): string
    {
        return $this->spanId;
    }

    /**
     * @param string $spanId
     * @return SpanBuilder
     */
    public function setSpanId(string $spanId): SpanBuilder
    {
        $this->spanId = $spanId;
        return $this;
    }

    /**
     * @return string
     */
    public function getRemote(): string
    {
        return $this->remote;
    }

    /**
     * @param string $remote
     * @return SpanBuilder
     */
    public function setRemote(string $remote): SpanBuilder
    {
        $this->remote = $remote;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isExportable(): bool
    {
        return $this->exportable;
    }

    /**
     * @param boolean $exportable
     * @return SpanBuilder
     */
    public function setExportable(bool $exportable): SpanBuilder
    {
        $this->exportable = $exportable;
        return $this;
    }

    /**
     * @return string
     */
    public function getProcessId(): string
    {
        return $this->processId;
    }

    /**
     * @param string $processId
     * @return SpanBuilder
     */
    public function setProcessId(string $processId): SpanBuilder
    {
        $this->processId = $processId;
        return $this;
    }

    /**
     * @return null|Span
     */
    public function getSavedSpan()
    {
        return $this->savedSpan;
    }

    /**
     * @param Span $savedSpan
     * @return SpanBuilder
     */
    public function setSavedSpan(Span $savedSpan): SpanBuilder
    {
        $this->savedSpan = $savedSpan;
        return $this;
    }

    /**
     * @return array
     */
    public function getLogs(): array
    {
        return $this->logs;
    }

    /**
     * @param array $logs
     * @return SpanBuilder
     */
    public function setLogs(array $logs): SpanBuilder
    {
        $this->logs = $logs;
        return $this;
    }

    public function addLog($log) : SpanBuilder
    {
        $this->logs[] = $log;
        return $this;
    }

    /**
     * @return array
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * @param array $tags
     * @return SpanBuilder
     */
    public function setTags(array $tags): SpanBuilder
    {
        $this->tags = $tags;
        return $this;
    }

    public function addTag($key, $value)
    {
        if (strlen($key) && strlen($value)) {
            $this->tags[$key] = $value;
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getBaggage(): array
    {
        return $this->baggage;
    }

    /**
     * @param array $baggage
     * @return SpanBuilder
     */
    public function setBaggage(array $baggage): SpanBuilder
    {
        $this->baggage = $baggage;
        return $this;
    }
}