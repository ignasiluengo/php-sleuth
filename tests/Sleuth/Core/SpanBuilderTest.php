<?php
/**
 * Created by PhpStorm.
 * User: ignasiluengo
 * Date: 8/3/17
 * Time: 11:51
 */

namespace Sleuth\Core;


class SpanBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SpanBuilder
     */
    private $builder;

    /**
     * @var array
     */
    private $collection = [1,2,3];

    /**
     *
     */
    protected function setUp()
    {

        $this->builder = (new SpanBuilder())
            ->setTraceId('11a38b9a-b3da-360f-9353-a5a725514269')
            ->setSpanId('11aaab12-b3da-360f-9353-a5a725514269')
            ->setProcessId('process')
            ->setName('span_test')
            ->setBaggage($this->collection)
            ->setBegin(10)
            ->setEnd(50)
            ->setRemote('remote')
            ->setExportable(true)
            ->setLogs($this->collection)
            ->setParents($this->collection);
    }

    public function test_main_fields()
    {
        $this->assertEquals('span_test', $this->builder->getName());
        $this->assertEquals('11a38b9a-b3da-360f-9353-a5a725514269', $this->builder->getTraceId());
        $this->assertEquals('11aaab12-b3da-360f-9353-a5a725514269', $this->builder->getSpanId());
        $this->assertEquals('remote', $this->builder->getRemote());
        $this->assertEquals('process', $this->builder->getProcessId());
        $this->assertEquals(10, $this->builder->getBegin());
        $this->assertEquals(50, $this->builder->getEnd());
        $this->assertTrue($this->builder->isExportable());
        $this->assertCollection($this->builder->getLogs());
        $this->assertCollection($this->builder->getParents());
        $this->assertCollection($this->builder->getBaggage());
    }

    public function test_tags()
    {
        $tags = ['tag-a' => 'a', 'tag-b' => 'b', 'tag-c' => 'c'];
        $this->builder->setTags($tags);
        $this->assertEquals($tags, $this->builder->getTags());

        $this->builder->addTag('tag-d', 'd');
        $this->assertCount(4, $this->builder->getTags());
    }

    public function test_log()
    {
        $logs = [
            'first log',
            'second log'
        ];
        $this->builder->setLogs($logs);
        $this->assertEquals($logs, $this->builder->getLogs());
        $this->builder->addLog('another log');
        $this->assertCount(3, $this->builder->getLogs());
    }

    public function test_saved_span()
    {
        $this->builder->setSavedSpan(Span::create());
        $this->assertInstanceOf(Span::class, $this->builder->getSavedSpan());
    }

    public function test_build()
    {
        $span = $this->builder->build();
        $this->assertInstanceOf(Span::class, $span);
    }

    private function assertCollection($value)
    {
        $res = array_diff($this->collection, $value);

        $this->assertEmpty($res);
    }

}