<?php

return [
    'borrowedItems.required' => 'Sélectionnez des jeux à emprunter.',
    'borrowedItems.*.distinct' => 'Le jeu :item a été ajouté plusieurs fois à l\'emprunt.',
    'borrowedItems.*.inventory_item_available' => 'Le jeu :item n\'est plus disponible.',
    'borrowerEmail.required' => 'Veuillez saisir l\'adresse mail de l\'utilisateur souhaitant emprunter.',
    'borrowerEmail.email' => 'Le format de cette adresse mail est incorrect.',
    'borrowerEmail.exists' => 'Cette adresse mail n\'existe pas dans notre base de données.',
    'borrowerPassword.required' => 'Veuillez saisir le mot de passe de l\'emprunteur.',
    'borrowerPassword.password_for' => 'Ce mot de passe est incorrect.',
    'startDate.required' => 'Renseignez une date de début d\'emprunt.',
    'startDate.after_or_equal' => 'La date d\'emprunt ne peut pas être inférieure à la date du jour.',
    'expectedReturnDate.required' => 'Renseignez une date de retour prévu.',
    'expectedReturnDate.after_or_equal' => 'La date de retour prévu doit être supérieure ou égale à la date d\'emprunt.',
    'guarantee.required' => 'Renseignez la caution.',
    'guarantee.numeric' => 'La caution doit être un nombre positif.',
    'guarantee.regex' => 'La caution doit être un nombre positif à deux décimales maximum.',
    'agreementCheck1.required' => 'Cet engagement est obligatoire.',
    'agreementCheck1.accepted' => 'Cet engagement est obligatoire.',
    'agreementCheck2.required' => 'Cet engagement est obligatoire.',
    'agreementCheck2.accepted' => 'Cet engagement est obligatoire.'
];