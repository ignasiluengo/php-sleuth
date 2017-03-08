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

        $this->builder = SpanBuilder::build()
            ->setName('span_test')
            ->setBaggage($this->collection)
            ->setBegin(10)
            ->setEnd(50)
            ->setExportable(true)
            ->setLogs($this->collection)
            ->setParents($this->collection);
    }

    public function test_main_fields()
    {
        $this->assertEquals('span_test', $this->builder->getName());
        $this->assertEquals(10, $this->builder->getBegin());
        $this->assertEquals(50, $this->builder->getEnd());
        $this->assertTrue($this->builder->isExportable());
        $this->assertCollection($this->builder->getLogs());
        $this->assertCollection($this->builder->getParents());
        $this->assertCollection($this->builder->getBaggage());
    }

    private function assertCollection($value)
    {
        $res = array_diff($this->collection, $value);

        $this->assertEmpty($res);
    }

}