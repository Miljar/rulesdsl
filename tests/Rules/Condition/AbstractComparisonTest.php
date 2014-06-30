<?php

class AbstractComparisonTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    protected $classname = '\\Rules\\Condition\\AbstractComparison';

    /**
     * @covers \Rules\Condition\AbstractComparison::__construct
     * @expectedException PHPUnit_Framework_Error_Warning
     */
    public function testConstructorRequiresArguments()
    {
        $arguments = array();
        $object = $this->getMockForAbstractClass(
            $this->classname,
            $arguments
        );
    }

    /**
     * @covers \Rules\Condition\AbstractComparison::__construct
     * @expectedException \Rules\Exception\InvalidArgumentException
     */
    public function testConstructorArgumentsShouldBeScalar()
    {
        $left = new \stdClass();
        $right = new \stdClass();
        $arguments = array($left, $right);
        $object = $this->getMockForAbstractClass(
            $this->classname,
            $arguments
        );
    }

    /**
     * Returns a mock object for AbstractComparison
     *
     * @return \Rules\Condition\AbstractComparison
     */
    private function getAbstractComparisonMock(array $methods = array())
    {
        $arguments = array(
            mt_rand(1, 100),
            mt_rand(1, 100),
        );
        $object = $this->getMockBuilder($this->classname)
            ->setMethods($methods)
            ->setConstructorArgs($arguments)
            ->getMockForAbstractClass();

        return $object;
    }

    /**
     * @covers \Rules\Condition\AbstractComparison::__construct
     */
    public function testConstructorSetsArgumentsInProperties()
    {
        $object = $this->getAbstractComparisonMock();

        $this->assertNotNull($object->left);
        $this->assertNotNull($object->right);
    }

    /**
     * @covers \Rules\Condition\AbstractComparison::__construct
     */
    public function testClassImplementsCorrectInterfaces()
    {
        $object = $this->getAbstractComparisonMock();

        $this->assertInstanceOf('\\Rules\\IsCondition', $object);
        $this->assertInstanceOf('\\Rules\\Condition\\Assessable', $object);
    }

    /**
     * @covers \Rules\Condition\AbstractComparison::whenTrue
     */
    public function testWhenTrueReturnsCurrentInstance()
    {
        $object = $this->getAbstractComparisonMock();
        $value = mt_rand(1, 1000);
        $result = $object->whenTrue($value);

        $this->assertSame($object, $result);
    }

    /**
     * @covers \Rules\Condition\AbstractComparison::whenTrue
     */
    public function testWhenTrueSetsInProperty()
    {
        $object = $this->getAbstractComparisonMock();
        $value = mt_rand(1, 1000);

        $this->assertTrue($object->positiveResult);
        $object->whenTrue($value);
        $this->assertEquals($value, $object->positiveResult);
    }

    /**
     * @covers \Rules\Condition\AbstractComparison::whenFalse
     */
    public function testWhenFalseReturnsCurrentInstance()
    {
        $object = $this->getAbstractComparisonMock();
        $value = mt_rand(1, 1000);
        $result = $object->whenFalse($value);

        $this->assertSame($object, $result);
    }

    /**
     * @covers \Rules\Condition\AbstractComparison::whenFalse
     */
    public function testWhenFalseSetsInProperty()
    {
        $object = $this->getAbstractComparisonMock();
        $value = mt_rand(1, 1000);

        $this->assertFalse($object->negativeResult);
        $object->whenFalse($value);
        $this->assertEquals($value, $object->negativeResult);
    }

    /**
     * @covers \Rules\Condition\AbstractComparison::breaksChain
     */
    public function testBreaksChainReturnsCurrentInstance()
    {
        $object = $this->getAbstractComparisonMock();
        $value = mt_rand(1, 1000);
        $result = $object->breaksChain($value);

        $this->assertSame($object, $result);
    }

    /**
     * @covers \Rules\Condition\AbstractComparison::breaksChain
     */
    public function testBreaksChainSetsInProperty()
    {
        $object = $this->getAbstractComparisonMock();
        $value = (bool) mt_rand(0, 1);

        $this->assertFalse($object->breaksChain);
        $object->breaksChain($value);
        $this->assertEquals($value, $object->breaksChain);
    }

    /**
     * @covers \Rules\Condition\AbstractComparison::reset
     */
    public function testResetCallsInternalMethods()
    {
        $object = $this->getAbstractComparisonMock(
            array(
                'whenTrue',
                'whenFalse',
                'breaksChain',
            )
        );

        $object->expects($this->once())
            ->method('whenTrue')
            ->with($this->equalTo(true))
            ->will($this->returnValue($object));

        $object->expects($this->once())
            ->method('whenFalse')
            ->with($this->equalTo(false))
            ->will($this->returnValue($object));

        $object->expects($this->once())
            ->method('breaksChain')
            ->with($this->equalTo(false))
            ->will($this->returnValue($object));

        $object->reset();
    }

    /**
     * @covers \Rules\Condition\AbstractComparison::__toString
     */
    public function testToStringReturnsString()
    {
        $object = $this->getAbstractComparisonMock();

        $this->assertInternalType('string', $object->__toString());
    }
}

