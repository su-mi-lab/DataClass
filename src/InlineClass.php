<?php

namespace DataClass;

use DataClass\Exception\AssignException;
use DataClass\Exception\FinalClassException;
use ReflectionClass;

abstract class InlineClass
{
    protected $value;

    /**
     * InlineClass constructor.
     *
     *
     * @throws FinalClassException
     * @throws \ReflectionException
     */
    final public function __construct($value)
    {
        $reflection = new ReflectionClass(static::class);

        if ($reflection->isFinal() === false) {
            throw new FinalClassException('final class only');
        }

        $this->value = $value;
    }

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @throws AssignException
     */
    final public function __set($name, $value)
    {
        throw new AssignException('can not assign');
    }

    abstract function value();
}