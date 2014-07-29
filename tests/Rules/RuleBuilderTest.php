<?php

class RuleBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    protected $classname = '\\Rules\\RuleBuilder';

    /**
     * @group internalDSL
     * @dataProvider dataProviderEndToEnd
     */
    public function testEndToEnd($betHome, $betAway, $matchHome, $matchAway, $expected)
    {
        $rb = new $this->classname;

        $rb->when(
            $rb->both(
                $rb->eq($betHome, $matchHome),
                $rb->eq($betAway, $matchAway)
            )
            ->result(3)
            ->end()
        )
        ->when(
            $rb->both(
                $rb->eq($betHome, $betAway),
                $rb->eq($matchHome, $matchAway)
            )
            ->result(1)
            ->end()
        )
        ->when(
            $rb->both(
                $rb->gt($betHome, $betAway),
                $rb->gt($matchHome, $matchAway)
            )
            ->result(1)
            ->end()
        )
        ->when(
            $rb->both(
                $rb->lt($betHome, $betAway),
                $rb->lt($matchHome, $matchAway)
            )
            ->result(1)
            ->end()
        )
        ->defaultsTo(0);

        $result = $rb->getResult();

        $this->assertEquals($expected, $result);
    }

    /**
     * Data provider for end-to-end test of RuleBuilder
     *
     * @return array
     */
    public function dataProviderEndToEnd()
    {
        return array(
            array(1, 0, 1, 0, 3), // correct score
            array(0, 0, 0, 0, 3), // correct score
            array(0, 1, 0, 1, 3), // correct score
            array(1, 0, 2, 0, 1), // correct home winner
            array(0, 1, 1, 2, 1), // correct away winner
            array(0, 0, 1, 1, 1), // correct draw
            array(1, 0, 0, 1, 0), // nothing correct
        );
    }
}
