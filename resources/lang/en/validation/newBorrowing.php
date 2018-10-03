<?php

return [
    'borrowedItems.required' => 'Select games to borrow.',
    'borrowedItems.*.distinct' => 'The game :item was added to the borrowing multiple times.',
    'borrowedItems.*.inventory_item_available' => 'The game :item is not available anymore.',
    'borrowerEmail.required' => 'Enter the borrower\'s registered email address.',
    'borrowerEmail.email' => 'The email address\' format is incorrect.',
    'borrowerEmail.exists' => 'This email address is not registered in our database.',
    'borrowerPassword.required' => 'Enter the borrower\'s password.',
    'borrowerPassword.password_for' => 'The password is incorrect.',
    'expectedReturnDate.required' => 'Choose the borrowing\'s expected return date.',
    'expectedReturnDate.after_or_equal' => 'The borrowing\'s expected return date must be superior or equal to the current date.',
    'guarantee.required' => 'Fill in the guarantee.',
    'guarantee.numeric' => 'The guarantee must be a positive number.',
    'guarantee.regex' => 'The guarantee must be a positive number with at most 2 decimals.',
    'agreementCheck1.required' => 'You must agree to these terms to proceed.',
    'agreementCheck1.accepted' => 'You must agree to these terms to proceed.',
    'agreementCheck2.required' => 'You must agree to these terms to proceed.',
    'agreementCheck2.accepted' => 'You must agree to these terms to proceed.'
];