<?php

return [
    'selectedBorrowings.required' => 'Sélectionnez des emprunts à terminer.',
    'selectedBorrowings.*.integer' => 'Un emprunt doit être représenté par son identifiant.',
    'selectedBorrowings.*.distinct' => 'L\'emprunt du jeu :item par :borrower a été choisi plusieurs fois.',
    'selectedBorrowings.*.exists' => 'L\'emprunt n\'existe pas.',
    'selectedBorrowings.*.no_self_return' => 'Un utilisateur ne peut pas valider le retour de son propre emprunt.',
    'selectedBorrowings.*.not_already_returned' => 'L\'emprunt du jeu :item par :borrower est déjà déclaré comme terminé.'
];