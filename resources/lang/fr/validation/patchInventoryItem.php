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
    'nameFr.unchanged_during_borrowing' => 'Le nom d\'un jeu en cours d\'emprunt ne peut pas être modifié.',
    'nameEn.unchanged_during_borrowing' => 'Le nom d\'un jeu en cours d\'emprunt ne peut pas être modifié.',
    'statusId.required' => 'Veuillez renseigner le statut actuel du jeu.',
    'statusId.integer' => 'Veuillez renseigner un statut valide par son id.',
    'statusId.exists' => 'Le statut renseigné n\'existe pas dans notre base de données.',
    'statusId.unchanged_during_borrowing' => 'Le statut d\'un jeu en cours d\'emprunt ne peut pas être modifié.',
    'statusId.not_changed_to_borrowed' => 'Il n\'est pas possible de modifier le statut d\'un jeu en "Emprunté" sans réaliser d\'emprunt.'
];