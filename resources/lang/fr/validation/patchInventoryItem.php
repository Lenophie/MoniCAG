<?php

return [
    'inventoryItemId.required' => 'Veuillez sélectionner un jeu à modifier.',
    'inventoryItemId.integer' => 'Veuillez sélectionner, par son id, un jeu valide à modifier.',
    'inventoryItemId.exists' => 'Le jeu sélectionné n\'existe pas dans notre base de données',
    'durationMin.integer' => 'La durée minimale doit être un entier.',
    'durationMin.min' => 'La durée minimale doit être positive.',
    'durationMax.integer' => 'La durée maximale doit être un entier.',
    'durationMax.min' => 'La durée maximale doit être positive.',
    'durationMax.gte' => 'La durée maximale doit être supérieure ou égale à la durée minimale.',
    'playersMin.integer' => 'Le nombre minimal de joueurs doit être un entier.',
    'playersMin.min' => 'Le nombre minimal de joueurs doit être strictement positif.',
    'playersMax.integer' => 'Le nombre maximal de joueurs doit être un entier.',
    'playersMax.min' => 'Le nombre maximal de joueurs doit être strictement positif.',
    'playersMax.gte' => 'Le nombre maximal de joueurs doit être supérieur ou égal au nombre minimal de joueurs.',
    'genres.required' => 'Veuillez renseigner au moins un genre pour ce jeu.',
    'genres.*.distinct' => 'Le genre :genre a été ajouté plusieurs fois.',
    'genres.*.exists' => 'Un genre sélectionné n\'existe pas dans notre base de données.',
    'nameFr.required' => 'Veuillez renseigner le nom français du jeu.',
    'nameEn.required' => 'Veuillez renseigner le nom anglais du jeu.',
    'nameFr.unchanged_during_borrowing' => 'Le nom d\'un jeu en cours d\'emprunt ne peut pas être modifié',
    'nameEn.unchanged_during_borrowing' => 'Le nom d\'un jeu en cours d\'emprunt ne peut pas être modifié',
    'status.required' => 'Veuillez renseigner le statut actuel du jeu.',
    'status.integer' => 'Veuillez renseigner un statut valide par son id.',
    'status.exists' => 'Le statut renseigné n\'existe pas dans notre base de données.'
];