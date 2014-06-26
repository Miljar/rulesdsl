<?php
/**
 * Defines the interface of assessable conditions
 * (conditions which can be evaluated)
 */

namespace Rules\Condition;

/**
 * Defines the interface of a assessable object
 *
 * @author Tom Van Herreweghe <tom@king-foo.be>
 */
interface Assessable
{
    /**
     * Evaluates the condition and returns
     * the result
     *
     * @return mixed
     */
    public function evaluate();
}
