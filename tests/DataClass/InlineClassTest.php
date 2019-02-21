<?php

use DataClass\Exception\AssignException;
use DataClass\Exception\FinalClassException;
use DataClass\InlineClass;
use PHPUnit\Framework\TestCase;

class InlineClassTest extends TestCase
{

    /**
     * @throws ReflectionException
     */
    public function testFinal()
    {
        try {
            new NgInlineClass("");
            $this->assertEquals(true, false);
        } catch (FinalClassException $e) {
            $this->assertEquals(true, true);
        }

        try {
            new Price("");
            $this->assertEquals(true, true);
        } catch (FinalClassException $e) {
            $this->assertEquals(true, false);
        }
    }

    /**
     * @throws Exception
     */
    public function testProperty()
    {
        $price = new Price("100");
        $this->assertEquals($price->value(), 100);
    }

    /**
     * @throws Exception
     */
    public function testCanNotAssign()
    {
        try {
            $price = new Price("100");

            $price->test = 'set';

            $this->assertEquals(true, false);
        } catch (AssignException $e) {
            $this->assertEquals(true, true);
        }
    }
}


class NgInlineClass extends InlineClass
{

    function value()
    {
        // TODO: Implement value() method.
    }
}

final class Price extends InlineClass
{

    function value(): int
    {
        return (int)$this->value;
    }
}