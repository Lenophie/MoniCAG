<?php

return [
    'userId.required' => 'Veuillez sélectionner un utilisateur à éditer.',
    'userId.integer' => 'Veuillez sélectionner, par son id, un utilisateur à éditer.',
    'userId.exists' => 'Cet utilisateur n\'existe pas dans notre base de données.',
    'userId.unchanged_if_other_admin' => 'Vous n\'avez pas la permission de modifier un autre administrateur.',
    'userId.not_involved_in_a_current_borrowing' => 'Un utilisateur impliqué dans un emprunt en cours ne peut pas être supprimé.'
];