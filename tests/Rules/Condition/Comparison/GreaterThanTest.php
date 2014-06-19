<?php

class GreaterThanTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    protected $classname = '\\Rules\\Condition\\Comparison\\GreaterThan';

    /**
     * @covers \Rules\Condition\Comparison\GreaterThan::__construct
     */
    public function testGreaterThanClassExtendsAbstractComparisonClass()
    {
        $object = new $this->classname(1, 2);

        $this->assertInstanceOf(
            '\\Rules\\Condition\\AbstractComparison',
            $object
        );
    }

    /**
     * @covers \Rules\Condition\Comparison\GreaterThan::evaluate
     * @dataProvider dataProviderEvaluate
     */
    public function testEvaluateCorrectlyEvaluatesLeftAndRight($left, $right, $expected)
    {
        $object = new $this->classname($left, $right);
        $this->assertEquals($expected, $object->evaluate());
    }

    /**
     * Data provider for evaluate() test functions
     *
     * @return array
     */
    public function dataProviderEvaluate()
    {
        return array(
            array(1, 2, false),
            array(2, 1, true),
            array(1, 1, false),
            array('left', 'right', false),
            array('right', 'left', true),
            array('left', 'left', false),
            array(0, 0.0, false),
        );
    }

    /**
     * @covers \Rules\Condition\Comparison\GreaterThan::evaluate
     */
    public function testEvaluateTrueReturnsPositiveResult()
    {
        $left = 2;
        $right = 1;
        $object = new $this->classname($left, $right);
        $result = $object->whenTrue('foo')
            ->whenFalse('bar')
            ->evaluate();

        $this->assertEquals('foo', $result);
    }

    /**
     * @covers \Rules\Condition\Comparison\GreaterThan::evaluate
     */
    public function testEvaluateFalseReturnsNegativeResult()
    {
        $left = 1;
        $right = 2;
        $object = new $this->classname($left, $right);
        $result = $object->whenTrue('foo')
            ->whenFalse('bar')
            ->evaluate();

        $this->assertEquals('bar', $result);
    }
}

