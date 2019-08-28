<?php

return [
    'titles' => [
        'home' => 'Accueil',
        'perform_borrowing' => 'Réaliser un emprunt',
        'retrieve_borrowing' => 'Récupérer un emprunt',
        'view_borrowings_history' => "Voir l'historique des emprunts",
        'borrowings_history' => 'Historique des emprunts',
        'view_inventory' => "Voir l'inventaire",
        'inventory' => 'Inventaire',
        'edit_inventory' => "Gérer l'inventaire",
        'edit_users' => 'Gérer les utilisateurs',
        'borrowings_management' => 'Gestion des emprunts',
        'inventory_management' => "Gestion de l'inventaire",
        'users_management' => 'Gestion des utilisateurs',
        'account' => 'Espace perso'
    ],
    'footer' => [
        'github' => 'Retrouve MoniCAG sur GitHub',
        'dark_theme' => 'Thème sombre',
        'light_theme' => 'Thème lumineux'
    ],
    'new_borrowing' => [
        'search_placeholder' => 'Chercher un jeu à emprunter',
        'confirm_title' => "Confirmation de l'emprunt",
        'selected_list' => 'Liste des jeux sélectionnés',
        'notes_placeholder' => "Ce champ est utilisé pour préciser des circonstances d'emprunt particulières (WEI, soirée...).\nCes notes doivent concerner l'emprunt plutôt que l'état des jeux empruntés.",
        'agreement_compensation' => "Je m'engage à dédommager le club jeux en cas de détérioration d'un jeu emprunté ou de perte de pièces",
        'agreement_reimbursement' => "Je m'engage à rembourser intégralement tout jeu emprunté s'il est perdu"
    ],
    'end_borrowing' => [
        'declaration' => [
            'content' => 'Déclarer les emprunts sélectionnés comme',
            'returned' => 'Rendus',
            'lost' => 'Perdus'
        ],
        'no_current' => "Pas d'emprunt en cours",
        'selected_list' => 'Liste des emprunts sélectionnés',
        'late' => "En retard",
        'selected_tag' => "Sélectionné",
        'modal' => [
            'title' => [
                'returned' => "Confirmation de retour d'emprunts",
                'lost' => "Confirmation de perte d'emprunts"
            ],
            'button' => [
                'returned' => 'Confirmer le retour',
                'lost' => 'Confirmer la perte',
            ]
        ]
    ],
    'borrowings_history' => [
        'deleted_user' => 'Utilisateur supprimé'
    ],
    'view_inventory' => [
        'filter_game_placeholder' => 'Rechercher un jeu...',
        'filter_genre_placeholder' => 'Filtrer par genre...',
        'filter_duration_placeholder' => 'Filtrer par durée...',
        'filter_players_placeholder' => 'Filtrer par nombre de joueurs...',
    ],
    'edit_inventory' => [
        'add_genre' => 'Ajouter un genre',
        'edit_genre' => 'Modifier le genre',
        'edit_genres' => 'Modifier les genres',
        'delete_genre' => 'Supprimer le genre',
        'add_item' => 'Ajouter un jeu',
        'edit_items' => 'Modifier les jeux',
        'edit_item' => 'Modifier le jeu',
        'delete_item' => 'Supprimer le jeu',
        'item_deletion_warning' => "Supprimer un jeu ne devrait être fait que si le jeu ne correspond pas, et n'a jamais correspondu, à un réel jeu de l'inventaire.<br/>Si le jeu a été perdu, vous devriez plutôt modifier son statut.<br/>Après avoir supprimé le jeu, tous ses emprunts seront supprimés de la base de données.<br/>Cette suppression est <b>irréversible</b>.",
        'genre_deletion_warning' => "Êtes-vous sûr de vouloir supprimer ce genre ?<br/>Cette suppression est <b>irréversible</b>",
    ],
    'edit_users' => [
        'change_role' => 'Changer le rôle'
    ],
    'account' => [
        'deletion_title' => 'Confirmer la suppression du compte',
        'deletion_warning' => "Votre compte et l'intégralité de vos données personnelles vont être supprimés.<br/>Cette action est <b>irréversible</b>."
    ],
];
