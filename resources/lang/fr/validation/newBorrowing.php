<?php

return [
    'borrowedItems.required' => 'Sélectionnez des jeux à emprunter.',
    'borrowedItems.array' => 'Les jeux à emprunter doivent être envoyés sous forme de liste.',
    'borrowedItems.*.integer' => 'Un jeu doit être représenté par son identifiant.',
    'borrowedItems.*.distinct' => 'Le jeu :item a été ajouté plusieurs fois à l\'emprunt.',
    'borrowedItems.*.exists' => 'Un jeu (:value) n\'existe plus.',
    'borrowedItems.*.inventory_item_available' => 'Le jeu :item n\'est plus disponible.',
    'borrowerEmail.required' => 'Veuillez saisir l\'adresse mail de l\'utilisateur souhaitant emprunter.',
    'borrowerEmail.email' => 'Le format de cette adresse mail est incorrect.',
    'borrowerEmail.exists' => 'Cette adresse mail n\'existe pas dans notre base de données.',
    'borrowerPassword.required' => 'Veuillez saisir le mot de passe de l\'emprunteur.',
    'borrowerPassword.password_for' => 'Ce mot de passe est incorrect.',
    'expectedReturnDate.required' => 'Renseignez une date de retour prévu.',
    'expectedReturnDate.after_or_equal' => 'La date de retour prévu doit être supérieure ou égale à la date d\'emprunt.',
    'guarantee.required' => 'Renseignez la caution.',
    'guarantee.numeric' => 'La caution doit être un nombre positif.',
    'guarantee.regex' => 'La caution doit être un nombre positif à deux décimales maximum.',
    'guarantee.max' => 'La caution doit être inférieure ou égale à 1000€.',
    'agreementCheck1.required' => 'Cet engagement est obligatoire.',
    'agreementCheck1.accepted' => 'Cet engagement est obligatoire.',
    'agreementCheck2.required' => 'Cet engagement est obligatoire.',
    'agreementCheck2.accepted' => 'Cet engagement est obligatoire.'
];