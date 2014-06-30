<?php

class AbstractLogicalTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    protected $classname = '\\Rules\\Condition\\AbstractLogical';

    /**
     * @covers \Rules\Condition\AbstractLogical::__construct
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
     * @covers \Rules\Condition\AbstractLogical::__construct
     * @expectedException \Rules\Exception\InvalidArgumentException
     */
    public function testConstructorArgumentsShouldImplementIsCondition()
    {
        $left = $this->getMock('\\stdClass');
        $right = $this->getMock('\\stdClass');
        $arguments = array($left, $right);
        $object = $this->getMockForAbstractClass(
            $this->classname,
            $arguments
        );
    }

    /**
     * @covers \Rules\Condition\AbstractLogical::__construct
     * @expectedException \Rules\Exception\InvalidArgumentException
     */
    public function testConstructorArgumentsShouldImplementAssessable()
    {
        $left = $this->getMock('\\Rules\\IsCondition');
        $right = $this->getMock('\\Rules\\IsCondition');
        $arguments = array($left, $right);
        $object = $this->getMockForAbstractClass(
            $this->classname,
            $arguments
        );
    }

    /**
     * Returns a mock object for AbstractLogical
     *
     * @return \Rules\Condition\AbstractLogical
     */
    private function getAbstractLogicalMock(array $methods = array())
    {
        $inputClassname = '\\Rules\\Condition\\AbstractComparison';
        $arguments = array(
            mt_rand(1, 100),
            mt_rand(1, 100),
        );
        $left = $this->getMockBuilder($inputClassname)
            ->setConstructorArgs($arguments)
            ->getMockForAbstractClass();
        $arguments = array(
            mt_rand(1, 100),
            mt_rand(1, 100),
        );
        $right = $this->getMockBuilder($inputClassname)
            ->setConstructorArgs($arguments)
            ->getMockForAbstractClass();

        $arguments = array(
            $left,
            $right,
        );
        $object = $this->getMockBuilder($this->classname)
            ->setMethods($methods)
            ->setConstructorArgs($arguments)
            ->getMockForAbstractClass();

        return $object;
    }

    /**
     * @covers \Rules\Condition\AbstractLogical::__construct
     */
    public function testConstructorSetsArgumentsInProperties()
    {
        $object = $this->getAbstractLogicalMock();

        $this->assertNotNull($object->left);
        $this->assertNotNull($object->right);
    }

    /**
     * @covers \Rules\Condition\AbstractLogical::__construct
     */
    public function testClassImplementsCorrectInterfaces()
    {
        $object = $this->getAbstractLogicalMock();

        $this->assertInstanceOf('\\Rules\\IsCondition', $object);
        $this->assertInstanceOf('\\Rules\\Condition\\Assessable', $object);
    }

    /**
     * @covers \Rules\Condition\AbstractLogical::whenTrue
     */
    public function testWhenTrueReturnsCurrentInstance()
    {
        $object = $this->getAbstractLogicalMock();
        $value = mt_rand(1, 1000);
        $result = $object->whenTrue($value);

        $this->assertSame($object, $result);
    }

    /**
     * @covers \Rules\Condition\AbstractLogical::whenTrue
     */
    public function testWhenTrueSetsInProperty()
    {
        $object = $this->getAbstractLogicalMock();
        $value = mt_rand(1, 1000);

        $this->assertTrue($object->positiveResult);
        $object->whenTrue($value);
        $this->assertEquals($value, $object->positiveResult);
    }

    /**
     * @covers \Rules\Condition\AbstractLogical::whenFalse
     */
    public function testWhenFalseReturnsCurrentInstance()
    {
        $object = $this->getAbstractLogicalMock();
        $value = mt_rand(1, 1000);
        $result = $object->whenFalse($value);

        $this->assertSame($object, $result);
    }

    /**
     * @covers \Rules\Condition\AbstractLogical::whenFalse
     */
    public function testWhenFalseSetsInProperty()
    {
        $object = $this->getAbstractLogicalMock();
        $value = mt_rand(1, 1000);

        $this->assertFalse($object->negativeResult);
        $object->whenFalse($value);
        $this->assertEquals($value, $object->negativeResult);
    }

    /**
     * @covers \Rules\Condition\AbstractLogical::breaksChain
     */
    public function testBreaksChainReturnsCurrentInstance()
    {
        $object = $this->getAbstractLogicalMock();
        $value = mt_rand(1, 1000);
        $result = $object->breaksChain($value);

        $this->assertSame($object, $result);
    }

    /**
     * @covers \Rules\Condition\AbstractLogical::breaksChain
     */
    public function testBreaksChainSetsInProperty()
    {
        $object = $this->getAbstractLogicalMock();
        $value = (bool) mt_rand(0, 1);

        $this->assertFalse($object->breaksChain);
        $object->breaksChain($value);
        $this->assertEquals($value, $object->breaksChain);
    }

    /**
     * @covers \Rules\Condition\AbstractLogical::reset
     */
    public function testResetCallsInternalMethods()
    {
        $object = $this->getAbstractLogicalMock(
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
     * @covers \Rules\Condition\AbstractLogical::__toString
     */
    public function testToStringReturnsString()
    {
        $object = $this->getAbstractLogicalMock();

        $this->assertInternalType('string', $object->__toString());
    }
}

