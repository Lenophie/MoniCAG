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
    'genres.*.distinct' => 'The genre :value was filled in multiple times', // TODO : Create custom validator to feed the name instead of the id to the message
    'genres.*.exists' => 'A selected genre doesn\'t exist in our database.',
    'nameFr.required' => 'Please fill in the item\'s french name.',
    'nameEn.required' => 'Please fill in the item\'s english name.',
    'status.required' => 'Please fill in the item\'s current status.',
    'status.integer' => 'Please fill in a valid item status by its id.',
    'status.exists' => 'The selected status doesn\'t exist in out database.'
];