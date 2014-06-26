<?php
/**
 * ConditionChain interface to define the functionality of
 * a ConditionChain object
 */

namespace Rules;

/**
 * Defines the interface of a ConditionChain object
 *
 * @author Tom Van Herreweghe <tom@king-foo.be>
 */
interface IsConditionChain
{
    /**
     * Add a condition to the chain
     *
     * @param IsCondition $condition
     * @return \Rules\IsConditionChain
     */
    public function addCondition(IsCondition $condition);

    /**
     * Evaluates the conditions in the chain
     *
     * @return mixed
     */
    public function evaluate();
}
