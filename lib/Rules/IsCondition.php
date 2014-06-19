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
interface IsCondition
{
    /**
     * If the condition evaluates to boolean TRUE,
     * return given value
     *
     * @param mixed $value
     * @return \Rules\IsCondition
     */
    public function whenTrue($value);

    /**
     * If the condition evaluates to boolean FALSE,
     * return given value
     *
     * @param mixed $value
     * @return \Rules\IsCondition
     */
    public function whenFalse($value);

    /**
     * Indicates that after evaluation of the condition,
     * no further processing of other conditions in the chain
     * should happen
     *
     * @param bool $value
     * @return \Rules\IsCondition
     */
    public function breaksChain($value = true);

    /**
     * Resets the given properties to the default values
     *
     * @return \Rules\IsCondition
     */
    public function reset();
}

