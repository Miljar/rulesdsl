<?php
/**
 * Condition chain implementation
 */

namespace Rules;

use Rules\Exception\InvalidArgumentException;

/**
 * Implementation of the Equal condition which
 * verifies if given input values are equal
 *
 * @author Tom Van Herreweghe <tom@king-foo.be>
 */
class ConditionChain implements IsConditionChain
{
    /**
     * @var array
     */
    protected $conditions = array();

    /**
     * ConditionChain constructor
     *
     * @param array $conditions Optional list of conditions
     * @return void
     */
    public function __construct(array $conditions = array())
    {
        $this->addConditions($conditions);
    }

    /**
     * Adds a list of conditions to the chain
     *
     * @param array $conditions
     * @return \Rules\ConditionChain
     */
    public function addConditions(array $conditions)
    {
        foreach ($conditions as $condition) {
            $this->addCondition($condition);
        }

        return $this;
    }

    /**
     * Adds a condition to the chain
     *
     * @param \Rules\IsCondition $condition
     * @return \Rules\IsConditionChain
     */
    public function addCondition(IsCondition $condition)
    {
        $this->conditions[] = $condition;

        return $this;
    }

    /**
     * Returns the condition at the given index
     *
     * @param int $index
     * @return \Rules\IsConditionChain
     * @throws \Rules\Exception\InvalidArgumentException
     */
    public function getCondition($index)
    {
        if (!array_key_exists($index, $this->conditions)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Index %1$s does not exist in the list of conditions',
                    $index
                )
            );
        }

        return $this->conditions[$index];
    }

    /**
     * Evaluats the conditions in the chain
     * When a condition breaks the chain and is
     * positively evaluated, this is the return value
     *
     * When no condition breaks the chain, the last condition
     * to be positively evaluated provides the return value
     *
     * @return mixed
     */
    public function evaluate()
    {
        $result = null;

        foreach ($this->conditions as $condition) {
            $result = $condition->evaluate();

            if ($result == $condition->positiveResult
                && $condition->breaksChain === true) {
                break;
            }
        }

        return $result;
    }
}
