<?php
/**
 * Abstract base class for Comparison condition
 */

namespace Rules\Condition;

use Rules\IsCondition;

/**
 * Implements base functionality for Comparison conditions
 *
 * @author Tom Van Herreweghe <tom@king-foo.be>
 */
abstract class AbstractComparison implements IsCondition
{
    /**
     * @var mixed
     */
    public $left;

    /**
     * @var mixed
     */
    public $right;

    /**
     * @var mixed Default true
     */
    public $positiveResult = true;

    /**
     * @var mixed Default false
     */
    public $negativeResult = false;

    /**
     * @var bool Default false
     */
    public $breaksChain = false;

    /**
     * Class constructor
     *
     * @param mixed $leftValue The value for the left side of the comparison
     * @param mixed $rightValue The value for the right side of the comparison
     * @return void
     */
    public function __construct($leftValue, $rightValue)
    {
        $this->left = $leftValue;
        $this->right = $rightValue;
    }

    /**
     * If the condition evaluates to boolean TRUE,
     * return given value
     *
     * @param mixed $value
     * @return \Rules\Condition
     */
    public function whenTrue($value)
    {
        $this->positiveResult = $value;

        return $this;
    }

    /**
     * If the condition evaluates to boolean FALSE,
     * return given value
     *
     * @param mixed $value
     * @return \Rules\Condition
     */
    public function whenFalse($value)
    {
        $this->negativeResult = $value;

        return $this;
    }

    /**
     * Indicates that after evaluation of the condition,
     * no further processing of other conditions in the chain
     * should happen
     *
     * @param bool $value
     * @return \Rules\Condition
     */
    public function breaksChain($value = true)
    {
        $this->breaksChain = (bool) $value;

        return $this;
    }

    /**
     * Evaluates the condition and returns
     * the result
     *
     * @return mixed
     */
    abstract public function evaluate();
}

