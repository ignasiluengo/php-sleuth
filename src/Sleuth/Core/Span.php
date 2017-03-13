<?php

namespace Sleuth\Core;

use Ramsey\Uuid\Uuid;

/**
 * Class Span
 * @package Sleuth\Core
 */
class Span implements SpanContext
{
    const SAMPLED_NAME = 'X-B3-Sampled';
    const PROCESS_ID_NAME = 'X-Process-Id';
    const PARENT_ID_NAME = 'X-B3-ParentSpanId';
    const TRACE_ID_NAME = 'X-B3-TraceId';
    const SPAN_NAME_NAME = 'X-Span-Name';
    const SPAN_ID_NAME = 'X-B3-SpanId';
    const SPAN_EXPORT_NAME = 'X-Span-Export';
    const SPAN_FLAGS = 'X-B3-Flags';
    const SPAN_BAGGAGE_HEADER_PREFIX = 'baggage';
    const SPAN_SAMPLED = '1';
    const SPAN_NOT_SAMPLED = '0';
    const SPAN_LOCAL_COMPONENT_TAG_NAME = 'lc';
    const SPAN_ERROR_TAG_NAME = 'error';
    const SPAN_HEADERS = [
        'SAMPLED_NAME',
        'PROCESS_ID_NAME',
        'PARENT_ID_NAME',
        'TRACE_ID_NAME',
        'SPAN_ID_NAME',
        'SPAN_NAME_NAME',
        'SPAN_EXPORT_NAME'
    ];
    const CLIENT_SEND = 'cs';
    const CLIENT_RECV = 'cr';
    const SERVER_SEND = 'ss';
    const SERVER_RECV = "sr";
    const SPAN_PEER_SERVICE_TAG_NAME = 'peer.service';
    const INSTANCEID = 'sleuth.instance_id';

    /**
     * @var string
     */
    private $name;

    /**
     * @var float
     */
    private $durationMicros;

    /**
     * @var float
     */
    private $begin;

    /**
     * @var float
     */
    private $end;

    /**
     * @var string uuid format ex: c4a760a8-dbcf-5254-a0d9-6a4474bd1b62
     */
    private $traceId;

    /**
     * @var string uuid format ex: c4a760a8-dbcf-5254-a0d9-6a4474bd1b62
     */
    private $spanId;

    /**
     * @var string
     */
    private $processId;

    /**
     * @var boolean
     */
    private $remote = false;

    /**
     * @var boolean
     */
    private $exportable = false;

    /**
     * @var array
     */
    private $tags = [];

    /**
     * @var array
     */
    private $baggage = [];

    /**
     * @var array
     */
    private $parents = [];

    /**
     * @var array
     */
    private $logs = [];

    /**
     * @var Span
     */
    private $savedSpan;

    /**
     * Span constructor.
     */
    private function __construct()
    {

    }

    public static function create()
    {
        return new self();
    }

    /**
     * @param SpanBuilder $builder
     * @return Span
     */
    public function makeFromBuilder(SpanBuilder $builder): Span
    {
        $span = new self();

        if ($builder->getBegin() > 0) {
            $span->begin = $builder->getBegin();
        } else {
            $span->begin = microtime(true);
        }

        if ($builder->getEnd() > 0) {
            $span->end = $builder->getEnd();
            $span->durationMicros = ($this->end - $this->begin);
        }

        $span->name = (strlen($builder->getName())) ? $builder->getName() : '';
        $span->traceId = $builder->getTraceId();
        $span->parents = $builder->getParents();

        $span->remote = $builder->getRemote();
        $span->exportable = $builder->isExportable();
        $span->processId = $builder->getProcessId();
        $span->savedSpan = $builder->getSavedSpan();
        $span->tags = $builder->getTags();
        $span->logs = $builder->getLogs();
        $span->baggage = $builder->getBaggage();

        return $span;
    }

    /**
     * @return array all zero or more baggage items propagating along with the associated Span
     */
    public function getBaggageItems()
    {
        return $this->baggage;
    }

    public function setBaggageItem($key, $value)
    {
        if (strlen($value)) {
            $this->baggage[$key] = $value;
        }
    }

    /**
     * @param $key
     * @return mixed|null
     */
    public function getBaggageItem($key)
    {
        if (isset($this->baggage[$key])) {
            return $this->baggage[$key];
        }

        return null;
    }

    /**
     * @return string
     */
    public function getProcessId() : string
    {
        return $this->processId;
    }

    /**
     * @return float
     */
    public function getAccumulatedMicros() : float
    {
        if (null !== $this->durationMicros) {
            return $this->durationMicros;
        }

        if (0 === $this->begin) {
            return 0;
        }

        $this->end = microtime(true);

        return ($this->end - $this->begin);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getTags() : array
    {
        return $this->tags;
    }

    public function addTag($key, $value)
    {
        if (strlen($value) && strlen($key)) {
            $this->tags[$key] = $value;
        }
    }

    public function isRunning()
    {
        return 0 !== $this->begin && $this->durationMicros === null;
    }

    public function tag($key, $value)
    {
        if (strlen($value)) {
            $this->tag[$key] = $value;
        }
    }

    public function generateTraceId()
    {
        return Uuid::uuid5()->toString();
    }

    public function getTraceId()
    {
        return $this->traceId;
    }

    /**
     * @return string
     */
    public function getSpanId(): string
    {
        return $this->spanId;
    }

    public function equals(Span $span)
    {
        return (
            $this->getTraceId() === $span->getTraceId() &&
            $this->getSpanId() === $span->getSpanId()
        );
    }

    /**
     * @param bool $value
     */
    public function exportable(bool $value)
    {
        $this->exportable = $value;
    }

    /**
     * @return bool
     */
    public function isExportable() : bool
    {
        return $this->exportable;
    }

    /**
     * @param bool $value
     */
    public function remote(bool $value)
    {
        $this->remote = $value;
    }

    /**
     * @return bool
     */
    public function isRemote() : bool
    {
        return $this->remote;
    }

    /**
     * return array
     */
    public function toArray(): array
    {
        return [
            'name' => $this->getName(),
            'traceId' => $this->getTraceId(),
            'parents' =>  $this->getParents(),
            'remote' =>  $this->getRemote(),
            'exportable' => $this->isExportable(),
            'processId' => $this->getProcessId(),
            'savedSpan' => $this->getSavedSpan(),
            'tags' => $this->getTags(),
            'logs' => $this->getLogs(),
            'baggage' => $this->getBaggage()
        ];
    }
}