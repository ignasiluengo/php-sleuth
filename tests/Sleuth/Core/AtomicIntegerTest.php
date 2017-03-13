<?php


namespace Sleuth\Core;

/**
 * Class AtomicIntegerTest
 * @package Sleuth\Core
 */
class AtomicIntegerTest extends \PHPUnit_Framework_TestCase
{
    public function test_get_simple_value()
    {
        $value = new AtomicInteger(3);
        $this->assertEquals(3, $value->get());
    }

    public function test_assert_that_result_is_equals_and_set_new_value()
    {
        $value = new AtomicInteger(5);
        $value->compareAndSet(5, 10);
        $this->assertEquals(10, $value->get());
    }

    public function test_assert_that_result_is_different_and_not_set_new_value()
    {
        $value = new AtomicInteger(5);
        $value->compareAndSet(2, 10);
        $this->assertNotEquals(10, $value->get());
    }

    public function test_get_and_increment_value()
    {
        $value = new AtomicInteger(2);
        $currentValue = $value->getAndIncrement();
        $incValue = $value->get();
        $this->assertEquals(2, $currentValue);
        $this->assertEquals(3, $incValue);
    }

    public function test_increment_and_get_value()
    {
        $value = new AtomicInteger(2);
        $incValue = $value->incrementAndGet();
        $this->assertEquals(3, $incValue);
    }

    public function test_get_and_decrement_value()
    {
        $value = new AtomicInteger(2);
        $currentValue = $value->getAndDecrement();
        $decrementValue = $value->get();

        $this->assertEquals(2, $currentValue);
        $this->assertEquals(1, $decrementValue);
        $this->assertEquals(1, $value->get());
    }

    public function test_decrement_and_get_value()
    {
        $value = new AtomicInteger(2);
        $decrement = $value->decrementAndGet();
        $this->assertEquals(1, $decrement);
        $this->assertEquals(1, $value->get());
    }

    public function test_add_and_get_value()
    {
        $value = new AtomicInteger(2);
        $res = $value->addAndGet(4);
        $this->assertEquals(6, $res);
    }

    /**
     * @expectedException \Sleuth\Core\AtomicIntegerException
     */
    public function test_clone_should_launch_exception()
    {
        $value = new AtomicInteger(5);
        $valueCloned = clone $value;
    }
}