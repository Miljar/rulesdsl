# [Rules v0.1](http://github.com/Miljar/rulesdsl) [![Build Status](https://travis-ci.org/Miljar/rulesdsl.svg?branch=master)](https://travis-ci.org/Miljar/rulesdsl)

## Introduction

Rules is a library to construct a set of rules in a more or less natural looking language.

The rules are flexible and can be extended at will. The goal is to be able to create a complex set of rules
to produce a single desired result.


## Usage

### Using PHP

```php
<?php
// Manually stitching things together (todo: implement ConditionChain)
$condition1 = new \Rules\Condition\Comparison\Equal(
    $bet->goals_home,
    $game->goals_home,
);
$condition2 = new \Rules\Condition\Comparison\Equal(
    $bet->goals_away,
    $game->goals_away,
);
$andCondition = new \Rules\Condition\Logical\LogicalAnd(
    $condition1,
    $condition2
);

$result = $andCondition->whenTrue(3)
    ->whenFalse(0)
    ->evaluate();

// $result == 3


// ConditionChain
$condition01 = new \Rules\Condition\Comparison\Equal(
    $bet->goals_home,
    $game->goals_home,
);
$condition02 = new \Rules\Condition\Comparison\Equal(
    $bet->goals_away,
    $game->goals_away,
);
$condition0 = new \Rules\Condition\Logical\LogicalAnd(
    $condition1,
    $condition2
);
$condition0->whenTrue(5)
    ->whenFalse(0)
    ->breaksChain();

$condition1 = new \Rules\Condition\Comparison\Equal(
    $bet->goals_home,
    $game->goals_home,
);
$condition1->whenTrue(3)
    ->whenFalse(0);

$condition2 = new \Rules\Condition\Comparison\Equal(
    $bet->goals_away,
    $game->goals_away,
);
$condition2->whenTrue(3)
    ->whenFalse(0);

$chain = new \Rules\ConditionChain();
$chain->addCondition($condition0);
$chain->addCondition($condition1);
$chain->addCondition($condition2);

$result = $chain->evaluate();


// Using ConditionBuilder (todo)
```

### Using DSL

_todo_

## Roadmap

1. Create base classes so the rules can be manually stitched together, and evaluated to produce a single result
1. Create ConditionChain class to chain together a bunch of conditions
1. Create a RulesBuilder to achieve the same result, but with a more fluent interface
1. Create a DSL on top of the existing code to allow a more natural looking programation

