<?php

class LowerThanTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    protected $classname = '\\Rules\\Condition\\Comparison\\LowerThan';

    /**
     * @covers \Rules\Condition\Comparison\LowerThan::__construct
     */
    public function testLowerThanClassExtendsAbstractComparisonClass()
    {
        $object = new $this->classname(1, 2);

        $this->assertInstanceOf(
            '\\Rules\\Condition\\AbstractComparison',
            $object
        );
    }

    /**
     * @covers \Rules\Condition\Comparison\LowerThan::evaluate
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
            array(1, 2, true),
            array(2, 1, false),
            array(1, 1, false),
            array('left', 'right', true),
            array('right', 'left', false),
            array('left', 'left', false),
            array(0, 0.0, false),
        );
    }

    /**
     * @covers \Rules\Condition\Comparison\LowerThan::evaluate
     */
    public function testEvaluateTrueReturnsPositiveResult()
    {
        $left = 1;
        $right = 2;
        $object = new $this->classname($left, $right);
        $result = $object->whenTrue('foo')
            ->whenFalse('bar')
            ->evaluate();

        $this->assertEquals('foo', $result);
    }

    /**
     * @covers \Rules\Condition\Comparison\LowerThan::evaluate
     */
    public function testEvaluateFalseReturnsNegativeResult()
    {
        $left = 2;
        $right = 1;
        $object = new $this->classname($left, $right);
        $result = $object->whenTrue('foo')
            ->whenFalse('bar')
            ->evaluate();

        $this->assertEquals('bar', $result);
    }
}

