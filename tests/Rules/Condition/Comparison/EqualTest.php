<?php

class EqualTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    protected $classname = '\\Rules\\Condition\\Comparison\\Equal';

    /**
     * @covers \Rules\Condition\Comparison\Equal::__construct
     */
    public function testEqualClassExtendsAbstractComparisonClass()
    {
        $object = new $this->classname(1, 2);

        $this->assertInstanceOf(
            '\\Rules\\Condition\\AbstractComparison',
            $object
        );
    }

    /**
     * @covers \Rules\Condition\Comparison\Equal::evaluate
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
            array(2, 1, false),
            array(1, 1, true),
            array('left', 'right', false),
            array('left', 'left', true),
            array(0, 0.0, true),
        );
    }

    /**
     * @covers \Rules\Condition\Comparison\Equal::evaluate
     */
    public function testEvaluateTrueReturnsPositiveResult()
    {
        $left = 1;
        $right = 1;
        $object = new $this->classname($left, $right);
        $result = $object->whenTrue('foo')
            ->whenFalse('bar')
            ->evaluate();

        $this->assertEquals('foo', $result);
    }

    /**
     * @covers \Rules\Condition\Comparison\Equal::evaluate
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

