<?php

return [
    'inventoryItemId.required' => 'Please select an inventory item to modify.',
    'inventoryItemId.integer' => 'Please select, by its id, a valid inventory item to modify.',
    'inventoryItemId.exists' => 'The select inventory item doesn\'t exist in our database.',
    'durationMin.integer' => 'The minimal duration must be an integer.',
    'durationMin.min' => 'The minimal duration must be positive.',
    'durationMax.integer' => 'The maximal duration must be an integer.',
    'durationMax.min' => 'The maximal duration must be positive.',
    'durationMax.gte' => 'The maximal duration must be greater or equal to the minimal duration.',
    'playersMin.integer' => 'The minimal number of players must be an integer.',
    'playersMin.min' => 'The minimal number of players must be stricly positive.',
    'playersMax.integer' => 'The maximal number of players must be an integer.',
    'playersMax.min' => 'The maximal number of players must be stricly positive.',
    'playersMax.gte' => 'The maximal number of players must be greater or equal to the minimal number of players.',
    'genres.required' => 'Please fill in at least one genre for this item.',
    'genres.*.distinct' => 'The genre :genre was added multiple times',
    'genres.*.exists' => 'A selected genre doesn\'t exist in our database.',
    'nameFr.required' => 'Please fill in the item\'s french name.',
    'nameEn.required' => 'Please fill in the item\'s english name.',
    'nameFr.unchanged_during_borrowing' => 'The name of a currently borrowed item can\'t be changed.',
    'nameEn.unchanged_during_borrowing' => 'The name of a currently borrowed item can\'t be changed.',
    'statusId.required' => 'Please fill in the item\'s current status.',
    'statusId.integer' => 'Please fill in a valid item status by its id.',
    'statusId.exists' => 'The selected status doesn\'t exist in out database.',
    'statusId.unchanged_during_borrowing' => 'The status of a currently borrowed item can\'t be changed.'
];