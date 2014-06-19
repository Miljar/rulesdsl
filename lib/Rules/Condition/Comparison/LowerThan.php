<?php
/**
 * Condition to determine if left input is strictly greater than
 * the right input
 */

namespace Rules\Condition\Comparison;

use Rules\Condition\AbstractComparison;

/**
 * Implementation of the LowerThan condition which
 * verifies if given left input value is strictly greater than
 * the right input value
 *
 * @author Tom Van Herreweghe <tom@king-foo.be>
 */
class LowerThan extends AbstractComparison
{
    /**
     * Evaluates the condition and returns
     * the result
     *
     * @return mixed
     */
    public function evaluate()
    {
        if ($this->left < $this->right) {
            return $this->positiveResult;
        }

        return $this->negativeResult;
    }
}

