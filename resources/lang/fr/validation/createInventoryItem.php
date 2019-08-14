<?php

return [
    'name.required' => 'Veuillez renseigner le nom du jeu.',
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
    'genres.*.distinct' => 'Le genre :genre a été renseigné plusieurs fois.',
    'genres.*.exists' => 'Un genre sélectionné (:value) n\'existe plus.',
    'altNames.*.distinct' => 'Le nom alternatif :altName a été renseigné plusieurs fois.',
];
