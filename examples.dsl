when bet.goals_home equals game.goals_home and bet.goals_away equals game.goals_away
set result to 3
stop processing

when bet.goals_home equals bet.goals_away and game.goals_home equals game.goals_away
set result to 1
stop processing

when bet.goals_home is greater than bet.goals_away and game.goals_home is greater than game.goals_away
set result to 1
stop processing

when bet.goals_home is lower than bet.goals_away and game.goals_home is lower than game.goals_away
set result to 1
stop processing

set result to 0
