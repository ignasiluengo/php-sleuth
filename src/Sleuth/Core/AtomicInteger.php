<?php
/**
 * Created by PhpStorm.
 * User: ignasiluengo
 * Date: 7/3/17
 * Time: 16:58
 */

namespace Sleuth\Core;

class AtomicIntegerException extends \Exception
{

}

final class AtomicInteger
{
    /**
     * @var int
     */
    private $lock = 0;

    /**
     * @var int
     */
    private $value;

    /**
     * AtomicInteger constructor.
     * @param int $value
     */
    public function __construct(int $value)
    {
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function get()
    {
        return $this->value;
    }


    public function __clone()
    {
        throw new \InvalidArgumentException("not clone");
    }

    /**
     * @param int $expect
     * @param int $update
     * @return bool
     */
    public function compareAndSet(int $expect, int $update) : bool
    {
        if ($expect === $this->get()) {
            $this->set($update);
        }
    }

    public function set(int $newValue)
    {
        if ($this->isLock()) {
            throw new AtomicIntegerException("number is locked");
        }
        $this->lock();
        $this->set($newValue);
        $this->unlock();
    }

    public function getAndIncrement() : int
    {
        $current = $this->get();
        $next = $current + 1;
        if ($this->compareAndSet($current, $next)) {
            return $current;
        }
    }

    public function getAndDecrement() : int
    {
        $current = $this->get();
        $decrement = $current - 1;
        if ($this->compareAndSet($current, $decrement)) {
            return $current;
        }
    }

    public function incrementAndGet() : int
    {
        $current = $this->get();
        $next = $current + 1;
        if ($this->compareAndSet($current, $next)) {
            return $next;
        }
    }

    public function addAndGet(int $delta) : int
    {
        $current = $this->get();
        $next = $current + $delta;
        if ($this->compareAndSet($current, $next)) {
            return $next;
        }
    }

    public function decrementAndGet() : int
    {
        $current = $this->get();
        $next = $current - 1;
        if ($this->compareAndSet($current, $next)) {
            return $next;
        }
    }

    /**
     * lock value accessor
     */
    private function lock()
    {
        $this->lock = true;
    }

    /**
     * unlock value accessor
     */
    private function unLock()
    {
        $this->lock = false;
    }

    /**
     * @return bool
     */
    public function isLock() : bool
    {
        return $this->lock;
    }
}