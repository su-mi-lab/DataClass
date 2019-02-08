<?php

use DataClass\Exception\AssignException;
use DataClass\Exception\FinalClassException;
use DataClass\Exception\PropertyException;
use PHPUnit\Framework\TestCase;
use DataClass\DataClass;

class DataClassTest extends TestCase
{

    /**
     * @throws Exception
     */
    public function testFinal()
    {
        try {
            new NgDataClass();
            $this->assertEquals(true, false);
        } catch (FinalClassException $e) {
            $this->assertEquals(true, true);
        }

        try {
            new User();
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
        try {
            new TestPropertyException;
            $this->assertEquals(true, false);
        } catch (PropertyException $e) {
            $this->assertEquals(true, true);
        }
    }

    /**
     * @throws Exception
     */
    public function testCanNotAssign()
    {
        try {
            $dataClass = new User();

            $dataClass->test = 'set';

            $this->assertEquals(true, false);
        } catch (AssignException $e) {
            $this->assertEquals(true, true);
        }
    }

    public function testSet()
    {
        try {
            $name = 'some name';
            $age = '13';
            $mail = 'some mail';
            $flag = true;
            $list = [1, 2, 3];

            $dataClass = new User(compact('name', 'age', 'mail', 'flag', 'list'));

            $this->assertEquals($dataClass->name, $name);
            $this->assertTrue($dataClass->age === (int)$age);
            $this->assertTrue($dataClass->flag === $flag);
            $this->assertTrue($dataClass->list === $list);
            $this->assertEquals($dataClass->mail, null);

        } catch (Exception $e) {
            $this->assertEquals(true, false);
        }
    }

    /**
     * @throws AssignException
     * @throws FinalClassException
     * @throws PropertyException
     */
    public function testCopy() {

        $name = 'some name';
        $age = '13';
        $flag = true;
        $list = [1, 2, 3];

        $dataClass = new User(compact('name', 'age', 'flag', 'list'));

        $copyDataClass = $dataClass->copy([
           'name' => 'update'
        ]);

        $this->assertNotEquals($dataClass->name, $copyDataClass->name);
        $this->assertEquals($dataClass->age, $copyDataClass->age);
        $this->assertEquals($dataClass->flag, $copyDataClass->flag);
        $this->assertEquals($dataClass->list, $copyDataClass->list);

    }
}

class NgDataClass extends DataClass
{

}

final class TestPropertyException extends DataClass
{

    private $test;

    protected $test2;

    public $test3;

    public function test() {
        return $this->test;
    }

}

/**
 * Class User
 *
 * @property string $name 名前
 * @property int    $age  年齢
 * @property bool   $flag
 * @property array  $list
 */
final class User extends DataClass
{
    public function test() {

    }
}