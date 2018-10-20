<?php

return [
    'userId.required' => 'Please select an user to edit.',
    'userId.integer' => 'Please select a valid user by its id.',
    'userId.exists' => 'This user doesn\'t exist in our database.',
    'userId.unchanged_if_other_admin' => 'You don\'t have the permission to modify another administrator.',
    'userId.not_involved_in_a_current_borrowing' => 'A user involved in an ongoing borrowing can\'t be deleted.'
];