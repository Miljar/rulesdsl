bet.goals_home = game.goals_home and bet.goals_away = game.goals_away
result = 3
stop

bet.goals_home = bet.goals_away and game.goals_home = game.goals_away
result = 1
stop

bet.goals_home > bet.goals_away and game.goals_home > game.goals_away
result = 1
stop

bet.goals_home < bet.goals_away and game.goals_home < game.goals_away
result = 1
stop

result = 0
