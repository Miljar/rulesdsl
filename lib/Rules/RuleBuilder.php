<?php
/**
 * Rules builder implementation
 */

namespace Rules;

use Rules\ConditionChain;
use Rules\Exception\UnsupportedConditionException;

/**
 * Builds a condition chain through a fluent interface
 *
 * @author Tom Van Herreweghe <tom@theanalogguy.be>
 */
class RuleBuilder
{
    /**
     * @var \Rules\IsConditionChain
     */
    protected $chain;

    /**
     * @var int
     */
    protected $index = -1;

    /**
     * @var \Rules\IsCondition
     */
    public $condition;

    /**
     * Maps a term to the corresponding condition
     *
     * @var array
     */
    protected $conditionMap = array(
        'equals' => '\\Rules\\Condition\\Comparison\\Equal',
        'lowerThan' => '\\Rules\\Condition\\Comparison\\LowerThan',
        'greaterThan' => '\\Rules\\Condition\\Comparison\\GreaterThan',
        'both' => '\\Rules\\Condition\\Logical\\LogicalAnd',
    );

    /**
     * RuleBuilder constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->chain = new ConditionChain();
    }

    /**
     * Creates a new rule in the condition chain
     *
     * @param \Rules\RuleBuilder $ruleBuilder
     * @return \Rules\RuleBuilder
     */
    public function when(\Rules\RuleBuilder $ruleBuilder)
    {
        $this->chain->addCondition($this->condition);
        $this->index++;
        $this->condition = null;

        return $this;
    }

    /**
     * Sets the result of current condition if evaluated to boolean TRUE
     *
     * @param mixed $value
     * @return \Rules\RuleBuilder
     */
    public function result($value)
    {
        if ($this->condition instanceof \Rules\IsCondition) {
            $this->condition->whenTrue($value);
        }

        return $this;
    }

    /**
     * Stops the evaluation of the chain for current condition
     *
     * @return \Rules\RuleBuilder
     */
    public function end()
    {
        $this->condition->breaksChain(true);

        return $this;
    }

    /**
     * Evaluates the conditions in the chain
     *
     * @return mixed
     */
    public function getResult()
    {
        return $this->chain->evaluate();
    }

    /**
     * Creates a condition of given type
     *
     * @param mixed $leftValue
     * @param mixed $rightValue
     * @return \Rules\RuleBuilder
     * @throws \Rules\Exception\UnsupportedConditionException
     */
    protected function createCondition($type, $leftValue, $rightValue = null)
    {
        if (!array_key_exists($type, $this->conditionMap)) {
            throw new UnsupportedConditionException(
                sprintf(
                    'Condition of type "%1$s" is not supported',
                    $type
                )
            );
        }

        if (null === $rightValue) {
            $this->condition = new $this->conditionMap[$type]($leftValue);
        } else {
            $this->condition = new $this->conditionMap[$type]($leftValue, $rightValue);
        }

        return clone $this;
    }

    /**
     * Creates a condition of type Equal
     *
     * @param mixed $leftValue
     * @param mixed $rightValue
     * @return \Rules\RuleBuilder
     */
    public function eq($leftValue, $rightValue)
    {
        return $this->equals($leftValue, $rightValue);
    }

    /**
     * Creates a condition of type Equal
     *
     * @param mixed $leftValue
     * @param mixed $rightValue
     * @return \Rules\RuleBuilder
     */
    public function equals($leftValue, $rightValue)
    {
        return $this->createCondition(__FUNCTION__, $leftValue, $rightValue);
    }

    /**
     * Creates a condition of type LowerThan
     *
     * @param mixed $leftValue
     * @param mixed $rightValue
     * @return \Rules\RuleBuilder
     */
    public function lt($leftValue, $rightValue)
    {
        return $this->lowerThan($leftValue, $rightValue);
    }

    /**
     * Creates a condition of type LowerThan
     *
     * @param mixed $leftValue
     * @param mixed $rightValue
     * @return \Rules\RuleBuilder
     */
    public function lowerThan($leftValue, $rightValue)
    {
        return $this->createCondition(__FUNCTION__, $leftValue, $rightValue);
    }

    /**
     * Creates a condition of type GreaterThan
     *
     * @param mixed $leftValue
     * @param mixed $rightValue
     * @return \Rules\RuleBuilder
     */
    public function gt($leftValue, $rightValue)
    {
        return $this->greaterThan($leftValue, $rightValue);
    }

    /**
     * Creates a condition of type GreaterThan
     *
     * @param mixed $leftValue
     * @param mixed $rightValue
     * @return \Rules\RuleBuilder
     */
    public function greaterThan($leftValue, $rightValue)
    {
        return $this->createCondition(__FUNCTION__, $leftValue, $rightValue);
    }

    /**
     * Creates a condition of type LogicalAnd
     *
     * @param \Rules\RuleBuilder $leftRB
     * @param \Rules\RuleBuilder $rightRB
     * @return \Rules\RuleBuilder
     */
    public function both(\Rules\RuleBuilder $leftRB, \Rules\RuleBuilder $rightRB)
    {
        return $this->createCondition(__FUNCTION__, $leftRB->condition, $rightRB->condition);
    }
}
