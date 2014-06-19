<?php

class LogicalAndTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    protected $classname = '\\Rules\\Condition\\Logical\\LogicalAnd';

    /**
     * Builds a mock object as input for the constructor of the SUT
     *
     * @param array $methods
     * @return \Rules\Condition\AbstractComparison
     */
    private function getConstructorArgument(array $methods = array())
    {
        $inputClassname = '\\Rules\\Condition\\AbstractComparison';
        $arguments = array(
            mt_rand(1, 100),
            mt_rand(1, 100),
        );
        $object = $this->getMockBuilder($inputClassname)
            ->setMethods($methods)
            ->setConstructorArgs($arguments)
            ->getMockForAbstractClass();

        return $object;
    }

    /**
     * @covers \Rules\Condition\Logical\LogicalAnd::__construct
     */
    public function testLogicalAndClassExtendsAbstractLogicalClass()
    {
        $left = $this->getConstructorArgument();
        $right = $this->getConstructorArgument();

        $object = new $this->classname($left, $right);

        $this->assertInstanceOf(
            '\\Rules\\Condition\\AbstractLogical',
            $object
        );
    }

    /**
     * @covers \Rules\Condition\Logical\LogicalAnd::evaluate
     */
    public function testEvaluateResetsInputArguments()
    {
        $left = $this->getConstructorArgument(array('reset'));
        $left->expects($this->once())
            ->method('reset');

        $right = $this->getConstructorArgument(array('reset'));
        $right->expects($this->once())
            ->method('reset');

        $object = new $this->classname($left, $right);
        $object->evaluate();
    }

    /**
     * @covers \Rules\Condition\Logical\LogicalAnd::evaluate
     */
    public function testEvaluateAssessesEachInputArgument()
    {
        $left = $this->getConstructorArgument(array('evaluate'));
        $left->expects($this->once())
            ->method('evaluate')
            ->will($this->returnValue(true));

        $right = $this->getConstructorArgument(array('evaluate'));
        $right->expects($this->once())
            ->method('evaluate')
            ->will($this->returnValue(true));

        $object = new $this->classname($left, $right);
        $object->evaluate();
    }

    /**
     * @covers \Rules\Condition\Logical\LogicalAnd::evaluate
     */
    public function testEvaluateTrueReturnsPositiveResult()
    {
        $left = $this->getConstructorArgument(array('evaluate'));
        $left->expects($this->once())
            ->method('evaluate')
            ->will($this->returnValue(true));

        $right = $this->getConstructorArgument(array('evaluate'));
        $right->expects($this->once())
            ->method('evaluate')
            ->will($this->returnValue(true));

        $object = new $this->classname($left, $right);
        $result = $object->whenTrue('foo')
            ->whenFalse('bar')
            ->evaluate();

        $this->assertEquals('foo', $result);
    }

    /**
     * @covers \Rules\Condition\Logical\LogicalAnd::evaluate
     */
    public function testEvaluateFalseReturnsNegativeResult()
    {
        $left = $this->getConstructorArgument(array('evaluate'));
        $left->expects($this->once())
            ->method('evaluate')
            ->will($this->returnValue(true));

        $right = $this->getConstructorArgument(array('evaluate'));
        $right->expects($this->once())
            ->method('evaluate')
            ->will($this->returnValue(false));

        $object = new $this->classname($left, $right);
        $result = $object->whenTrue('foo')
            ->whenFalse('bar')
            ->evaluate();

        $this->assertEquals('bar', $result);
    }

    /**
     * @covers \Rules\Condition\Logical\LogicalAnd::evaluate
     */
    public function testEndToEnd()
    {
        $left = new \Rules\Condition\Comparison\Equal(1, 1);
        $right = new \Rules\Condition\Comparison\Equal('foo', 'foo');
        $and = new $this->classname($left, $right);
        $result = $and->whenTrue('yes')
            ->whenFalse('no')
            ->evaluate();

        $this->assertEquals('yes', $result);
    }
}


