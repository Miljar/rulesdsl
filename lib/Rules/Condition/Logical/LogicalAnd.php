<?php
/**
 * Condition to determine the locical AND result of two
 * input conditions
 */

namespace Rules\Condition\Logical;

use Rules\Condition\AbstractLogical;

/**
 * Implementation of the logical AND condition
 * determines the result of the two input conditions
 *
 * @author Tom Van Herreweghe <tom@king-foo.be>
 */
class LogicalAnd extends AbstractLogical
{
    /**
     * Evaluates the condition and returns
     * the result
     *
     * @return mixed
     */
    public function evaluate()
    {
        // Reset some of the properties of the input conditions
        $this->left->reset();
        $this->right->reset();

        if ($this->left->evaluate() && $this->right->evaluate()) {
            return $this->positiveResult;
        }

        return $this->negativeResult;
    }
}
