<?php

return [
    'titles' => [
        'home' => 'Home',
        'perform_borrowing' => 'Perform borrowing',
        'retrieve_borrowing' => 'Retrieve borrowing',
        'view_borrowings_history' => 'View borrowings history',
        'borrowings_history' => 'Borrowings history',
        'view_inventory' => 'View inventory',
        'inventory' => 'Inventory',
        'edit_inventory' => 'Manage inventory',
        'edit_users' => 'Manage users',
        'borrowings_management' => 'Borrowings management',
        'inventory_management' => 'Inventory management',
        'users_management' => 'Users management',
        'github' => 'Checkout MoniCAG on GitHub',
    ],
    'new_borrowing' => [
        'search_placeholder' => 'Find a game to borrow',
        'confirm_title' => 'Borrowing confirmation',
        'selected_list' => 'Selected games',
        'notes_placeholder' => "This field is used to specify particular borrowing circumstances (WEI, party...).\nThese notes revolve around the borrowing itself rather than the condition of the borrowed games.",
        'agreement_compensation' => "I agree to compensate the club in the event of damage or loss of pieces of any borrowed game",
        'agreement_reimbursement' => "I agree to completely reimburse any borrowed game in the event of its loss"
    ],
    'end_borrowing' => [
        'declaration' => [
            'content' => 'Declare the selected borrowings as',
            'returned' => 'Returned',
            'lost' => 'Lost'
        ],
        'no_current' => 'No ongoing borrowing',
        'selected_list' => 'Selected borrowings',
        'late' => 'Late',
        'selected_tag' => 'Selected',
        'modal' => [
            'title' => [
                'returned' => "Confirm borrowings return",
                'lost' => "Confirm borrowings loss"
            ],
            'button' => [
                'returned' => 'Confirm return',
                'lost' => 'Confirm loss',
            ]
        ]
    ],
    'borrowings_history' => [
        'deleted_user' => 'Deleted user'
    ],
    'view_inventory' => [
        'filter_game_placeholder' => 'Search a game...',
        'filter_genre_placeholder' => 'Filter by genre...',
        'filter_duration_placeholder' => 'Filter by duration...',
        'filter_players_placeholder' => 'Filter by number of players...',
    ],
    'edit_inventory' => [
        'change_status' => 'Change status',
        'new_genre' => 'New genre',
        'edit_items' => 'Edit items',
        'add_item' => 'Add item',
        'deletion_title' => 'Confirm deletion',
        'deletion_warning' => "Deleting an item should only be done if the item doesn't, and never did, correspond to an actual inventory item.\nIf the item was lost, you should rather change its status.\nAfter deleting an item, all its borrowings will be deleted as well from the database.\nThis deletion can't be undone."
    ],
    'edit_users' => [
        'change_role' => 'Change role'
    ]
];