<?php

return [
    'selectedBorrowings.required' => 'Select borrowings to end.',
    'selectedBorrowings.*.integer' => 'A borrowing must be identified by its id.',
    'selectedBorrowings.*.distinct' => 'The borrowing of :item by :borrower was selected in multiple times.',
    'selectedBorrowings.*.exists' => 'The borrowing doesn\'t exist.',
    'selectedBorrowings.*.no_self_return' => 'A user can\'t confirm the return of one of its own borrowings.',
    'selectedBorrowings.*.not_already_returned' => 'The borrowing of :item by :borrower is already declared as finished.'
];