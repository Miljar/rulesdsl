<?php
/**
 * Condition to determine if given input values are equal
 */

namespace Rules;

use Rules\Condition\AbstractComparison;

/**
 * Implementation of the Equal condition which
 * verifies if given input values are equal
 *
 * @author Tom Van Herreweghe <tom@king-foo.be>
 */
class Equal extends AbstractComparison
{
    /**
     * Evaluates the condition and returns
     * the result
     *
     * @return mixed
     */
    public function evaluate()
    {
        if ($this->left == $this->right) {
            return $this->positiveResult;
        }

        return $this->negativeResult;
    }
}

