<?php
/**
 * Condition interface to define the functionality of
 * a Condition object
 */

namespace Rules;

/**
 * Defines the interface of a Condition object
 *
 * @author Tom Van Herreweghe <tom@king-foo.be>
 */
interface Condition
{
    /**
     * If the condition evaluates to boolean TRUE,
     * return given value
     *
     * @param mixed $value
     * @return \Rules\Condition
     */
    public function whenTrue($value);

    /**
     * If the condition evaluates to boolean FALSE,
     * return given value
     *
     * @param mixed $value
     * @return \Rules\Condition
     */
    public function whenFalse($value);

    /**
     * Indicates that after evaluation of the condition,
     * no further processing of other conditions in the chain
     * should happen
     *
     * @param bool $value
     * @return \Rules\Condition
     */
    public function breaksChain($value = true);

    /**
     * Evaluates the condition and returns
     * the result
     *
     * @return mixed
     */
    public function evaluate();
}

