<?php

return [
    'borrowedItems.required' => 'Select games to borrow.',
    'borrowedItems.array' => 'The selected games must be sent as an array.',
    'borrowedItems.*.integer' => 'A game must be identified by its id.',
    'borrowedItems.*.distinct' => 'The game :item was added to the borrowing multiple times.',
    'borrowedItems.*.exists' => 'A game (:value) doesn\'t exist anymore.',
    'borrowedItems.*.inventory_item_available' => 'The game :item is not available anymore.',
    'borrowerEmail.required' => 'Enter the borrower\'s registered email address.',
    'borrowerEmail.email' => 'The email address\' format is incorrect.',
    'borrowerEmail.exists' => 'This email address is not registered in our database.',
    'borrowerPassword.required' => 'Enter the borrower\'s password.',
    'borrowerPassword.password_for' => 'The password is incorrect.',
    'expectedReturnDate.required' => 'Choose the borrowing\'s expected return date.',
    'expectedReturnDate.after_or_equal' => 'The borrowing\'s expected return date must be superior or equal to the current date.',
    'expectedReturnDate.before_or_equal' => 'The borrowing must last a month at most.',
    'guarantee.required' => 'Fill in the guarantee.',
    'guarantee.numeric' => 'The guarantee must be a positive number.',
    'guarantee.regex' => 'The guarantee must be a positive number with at most 2 decimals.',
    'guarantee.max' => 'The guarantee must be inferior or equal to 1000€.',
    'agreementCheck1.required' => 'You must agree to these terms to proceed.',
    'agreementCheck1.accepted' => 'You must agree to these terms to proceed.',
    'agreementCheck2.required' => 'You must agree to these terms to proceed.',
    'agreementCheck2.accepted' => 'You must agree to these terms to proceed.'
];