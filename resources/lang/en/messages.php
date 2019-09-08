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
        'account' => 'Personal space'
    ],
    'footer' => [
        'github' => 'Checkout MoniCAG on GitHub',
        'dark_theme' => 'Night theme',
        'light_theme' => 'Light theme'
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
        'add_genre' => 'Add genre',
        'edit_genres' => 'Edit genres',
        'edit_genre' => 'Edit genre',
        'delete_genre' => 'Delete genre',
        'add_item' => 'Add item',
        'edit_items' => 'Edit items',
        'edit_item' => 'Edit item',
        'delete_item' => 'Delete item',
        'item_deletion_warning' => "Deleting an item should only be done if the item doesn't, and never did, correspond to an actual inventory item.</br>If the item was lost, you should rather change its status.</br>After deleting an item, all its borrowings will be deleted as well from the database.</br><b>This deletion can't be undone.</b>",
        'genre_deletion_warning' => "Are you sure you want to delete this genre ?</br><b>This deletion can't be undone.</b>"
    ],
    'edit_users' => [
        'change_role' => 'Change role',
        'delete_user' => 'Delete user',
        'user_deletion_warning' => "Deleting a user should only be done if the user doesn't, and never did, correspond to a real person.</br>After deleting a user, their borrowings won't be deleted from the database but the corresponding personal info will.</br><b>This deletion can't be undone.</b>"
    ],
    'account' => [
        'deletion_title' => 'Confirm account deletion',
        'deletion_warning' => "Your account will be deleted along with all your personal data.<br/><b>This deletetion can't be undone.</b>"
    ],
];
