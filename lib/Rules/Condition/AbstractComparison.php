<?php
/**
 * Abstract base class for Comparison condition
 */

namespace Rules\Condition;

use Rules\IsCondition;
use Rules\Exception\InvalidArgumentException;

/**
 * Implements base functionality for Comparison conditions
 *
 * @author Tom Van Herreweghe <tom@king-foo.be>
 */
abstract class AbstractComparison implements IsCondition, Assessable
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
        if (!is_scalar($leftValue)) {
            throw new InvalidArgumentException(
                'Left value is not a scalar value'
            );
        }

        if (!is_scalar($rightValue)) {
            throw new InvalidArgumentException(
                'Right value is not a scalar value'
            );
        }

        $this->left = $leftValue;
        $this->right = $rightValue;
    }

    /**
     * If the condition evaluates to boolean TRUE,
     * return given value
     *
     * @param mixed $value
     * @return \Rules\IsCondition
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
     * @return \Rules\IsCondition
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
     * @return \Rules\IsCondition
     */
    public function breaksChain($value = true)
    {
        $this->breaksChain = (bool) $value;

        return $this;
    }

    /**
     * Resets the given properties to the default values
     *
     * @return \Rules\IsCondition
     */
    public function reset()
    {
        return $this->whenTrue(true)
            ->whenFalse(false)
            ->breaksChain(false);
    }

    /**
     * Evaluates the condition and returns
     * the result
     *
     * @return mixed
     */
    abstract public function evaluate();

    /**
     * __toString method
     *
     * @return string
     */
    public function __toString()
    {
        return get_class($this) . ':left:' . $this->left . ':right:' . $this->right;
    }
}
