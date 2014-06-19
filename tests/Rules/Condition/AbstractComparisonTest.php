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
     * Returns a mock object for AbstractComparison
     *
     * @return \Rules\Condition\AbstractComparison
     */
    private function getAbstractComparisonMock()
    {
        $arguments = array(
            mt_rand(1, 100),
            mt_rand(1, 100),
        );
        $object = $this->getMockForAbstractClass(
            $this->classname,
            $arguments
        );

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
}

