user.goals_home = game.goals_home and user.goals_away = game.goals_away
result = 3
stop

user.goals_home = user.goals_away and game.goals_home = game.goals_away
result = 1
stop

user.goals_home > user.goals_away and game.goals_home > game.goals_away
result = 1
stop

user.goals_home < user.goals_away and game.goals_home < game.goals_away
result = 1
stop

result = 0
