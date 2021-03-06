<?php

return [
    'name.required' => 'Veuillez renseigner le nom du jeu.',
    'name.unchanged_during_borrowing' => 'Le nom d\'un jeu en cours d\'emprunt ne peut pas être modifié.',
    'name.unique' => 'Le nom du jeu doit être unique.',
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
    'genres.*.integer' => 'Un genre doit être représenté par son identifiant.',
    'genres.*.distinct' => 'Le genre :genre a été ajouté plusieurs fois.',
    'genres.*.exists' => 'Un genre (:value) n\'existe plus.',
    'altNames.*.distinct' => 'Le nom alternatif :altName a été renseigné plusieurs fois.',
    'statusId.required' => 'Veuillez renseigner le statut actuel du jeu.',
    'statusId.integer' => 'Veuillez renseigner un statut valide par son id.',
    'statusId.exists' => 'Le statut renseigné n\'existe pas dans notre base de données.',
    'statusId.unchanged_during_borrowing' => 'Le statut d\'un jeu en cours d\'emprunt ne peut pas être modifié.',
    'statusId.not_changed_to_borrowed' => 'Il n\'est pas possible de modifier le statut d\'un jeu en "Emprunté" sans réaliser d\'emprunt.'
];
