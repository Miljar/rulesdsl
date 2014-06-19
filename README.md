# [Rules v0.1](http://github.com/Miljar/rulesdsl)

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

// Using RulesBuilder (todo)
```

### Using DSL

_todo_

## Roadmap

1. Create base classes so the rules can be manually stitched together, and evaluated to produce a single result
2. Create a RulesBuilder to achieve the same result, but with a more fluent interface
3. Create a DSL on top of the existing code to allow a more natural looking programation

