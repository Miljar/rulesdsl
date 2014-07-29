<?php

class ConditionChainTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    protected $classname = '\\Rules\\ConditionChain';

    /**
     * @covers \Rules\ConditionChain::__construct
     */
    public function testConstructorCallsInternalMethodWithArguments()
    {
        $conditions = array();

        // Get mock, without the constructor being called
        $mock = $this->getMockBuilder($this->classname)
            ->disableOriginalConstructor()
            ->getMock();

        // set expectations for constructor calls
        $mock->expects($this->once())
            ->method('addConditions')
            ->with(
                $this->equalTo($conditions)
            );

        // now call the constructor
        $reflectedClass = new ReflectionClass($this->classname);
        $constructor = $reflectedClass->getConstructor();
        $constructor->invoke($mock, $conditions);
    }

    /**
     * @covers \Rules\ConditionChain::__construct
     */
    public function testConstructorCallsInternalMethodWithoutArguments()
    {
        // Get mock, without the constructor being called
        $mock = $this->getMockBuilder($this->classname)
            ->disableOriginalConstructor()
            ->getMock();

        // set expectations for constructor calls
        $mock->expects($this->once())
            ->method('addConditions')
            ->with(
                $this->equalTo(array())
            );

        // now call the constructor
        $reflectedClass = new ReflectionClass($this->classname);
        $constructor = $reflectedClass->getConstructor();
        $constructor->invoke($mock);
    }

    /**
     * @covers \Rules\ConditionChain::addConditions
     */
    public function testAddConditionsReturnsCurrentInstance()
    {
        $object = new $this->classname();
        $conditions = array();
        $result = $object->addConditions($conditions);

        $this->assertSame($object, $result);
    }

    /**
     * @covers \Rules\ConditionChain::addConditions
     */
    public function testAddConditionsCallsInternalMethod()
    {
        $conditionMock = $this->getMock('\\Rules\\IsCondition');
        $conditions = array(
            clone $conditionMock,
            clone $conditionMock,
            clone $conditionMock,
            clone $conditionMock,
            clone $conditionMock,
        );
        $mock = $this->getMock($this->classname, array('addCondition'));
        $mock->expects($this->exactly(count($conditions)))
            ->method('addCondition');
        $mock->addConditions($conditions);
    }

    /**
     * @covers \Rules\ConditionChain::addCondition
     */
    public function testAddConditionReturnsCurrentInstance()
    {
        $conditionMock = $this->getMock('\\Rules\\IsCondition');
        $object = new $this->classname();
        $result = $object->addCondition($conditionMock);

        $this->assertSame($object, $result);
    }

    /**
     * @covers \Rules\ConditionChain::addCondition
     */
    public function testAddConditionAddsConditionInList()
    {
        $conditionMock = $this->getMock('\\Rules\\IsCondition');
        $object = new $this->classname();

        $reflProp = new \ReflectionProperty($this->classname, 'conditions');
        $reflProp->setAccessible(true);

        $this->assertCount(0, $reflProp->getValue($object));

        $result = $object->addCondition($conditionMock);

        $this->assertCount(1, $reflProp->getValue($object));
    }

    /**
     * @covers \Rules\ConditionChain::getCondition
     * @expectedException \Rules\Exception\InvalidArgumentException
     */
    public function testGetConditionThrowsExceptionForIllegalIndex()
    {
        $index = mt_rand(0, 100);
        $object = new $this->classname();
        $object->getCondition($index);
    }

    /**
     * @covers \Rules\ConditionChain::getCondition
     */
    public function testGetConditionReturnsCorrectObjectForExistingIndex()
    {
        $conditionMock1 = $this->getMock('\\Rules\\IsCondition');
        $conditionMock2 = $this->getMock('\\Rules\\IsCondition');
        $conditionMock3 = $this->getMock('\\Rules\\IsCondition');
        $conditionMock4 = $this->getMock('\\Rules\\IsCondition');
        $conditionMock0 = $this->getMock('\\Rules\\IsCondition');
        $object = new $this->classname();

        $reflProp = new \ReflectionProperty($this->classname, 'conditions');
        $reflProp->setAccessible(true);
        $reflProp->setValue(
            $object,
            array(
                $conditionMock0,
                $conditionMock1,
                $conditionMock2,
                $conditionMock3,
                $conditionMock4,
            )
        );

        $index = mt_rand(0, 4);

        $this->assertSame(
            ${'conditionMock' . $index},
            $object->getCondition($index)
        );
    }

    /**
     * @covers \Rules\ConditionChain::evaluate
     */
    public function testEvaluateReturnsNullIfNoConditionsAreSet()
    {
        $object = new $this->classname();
        $result = $object->evaluate();

        $this->assertNull($result);
    }

    /**
     * @covers \Rules\ConditionChain::evaluate
     */
    public function testEvaluateEvaluatesEachConditionInTheChain()
    {
        $amount = mt_rand(2, 10);
        $conditions = array();
        for ($i = 0; $i < $amount; $i++) {
            $conditionMock = $this->getMockBuilder('\\Rules\\Condition\\Comparison\\Equal')
                ->setMethods(array('evaluate'))
                ->disableOriginalConstructor()
                ->getMock();
            $conditionMock->expects($this->once())
                ->method('evaluate')
                ->will($this->returnValue(true));

            $conditions[] = $conditionMock;
        }
        $object = new $this->classname($conditions);
        $result = $object->evaluate();

        $this->assertTrue($result);
    }

    /**
     * @covers \Rules\ConditionChain::evaluate
     */
    public function testEvaluateBreaksChainStopsEvaluationOnPositiveResult()
    {
        $amount = mt_rand(2, 10);
        $conditions = array();
        for ($i = 0; $i < $amount; $i++) {
            $conditionMock = $this->getMockBuilder('\\Rules\\Condition\\Comparison\\Equal')
                ->setMethods(array('evaluate'))
                ->disableOriginalConstructor()
                ->getMock();

            if ($i === 0) {
                $conditionMock->expects($this->once())
                    ->method('evaluate')
                    ->will($this->returnValue(true));
                $conditionMock->breaksChain();
            } else {
                $conditionMock->expects($this->never())
                    ->method('evaluate');
            }

            $conditions[] = $conditionMock;
        }
        $object = new $this->classname($conditions);
        $result = $object->evaluate();

        $this->assertTrue($result);
    }

    /**
     * @covers \Rules\ConditionChain::evaluate
     */
    public function testEvaluateBreaksChainDoesNotStopEvaluationOnNegativeResult()
    {
        $amount = mt_rand(2, 10);
        $conditions = array();
        for ($i = 0; $i < $amount; $i++) {
            $conditionMock = $this->getMockBuilder('\\Rules\\Condition\\Comparison\\Equal')
                ->setMethods(array('evaluate'))
                ->disableOriginalConstructor()
                ->getMock();

            if ($i === 0) {
                $conditionMock->expects($this->once())
                    ->method('evaluate')
                    ->will($this->returnValue(false));
                $conditionMock->breaksChain();
            } else {
                $conditionMock->expects($this->once())
                    ->method('evaluate')
                    ->will($this->returnValue(true));
            }

            $conditions[] = $conditionMock;
        }
        $object = new $this->classname($conditions);
        $result = $object->evaluate();

        $this->assertTrue($result);
    }
}

