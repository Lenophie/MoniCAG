<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'The :attribute must be accepted.',
    'active_url'           => 'The :attribute is not a valid URL.',
    'after'                => 'The :attribute must be a date after :date.',
    'after_or_equal'       => 'The :attribute must be a date after or equal to :date.',
    'alpha'                => 'The :attribute may only contain letters.',
    'alpha_dash'           => 'The :attribute may only contain letters, numbers, dashes and underscores.',
    'alpha_num'            => 'The :attribute may only contain letters and numbers.',
    'array'                => 'The :attribute must be an array.',
    'before'               => 'The :attribute must be a date before :date.',
    'before_or_equal'      => 'The :attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file'    => 'The :attribute must be between :min and :max kilobytes.',
        'string'  => 'The :attribute must be between :min and :max characters.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'The :attribute field must be true or false.',
    'confirmed'            => 'The :attribute confirmation does not match.',
    'date'                 => 'The :attribute is not a valid date.',
    'date_format'          => 'The :attribute does not match the format :format.',
    'different'            => 'The :attribute and :other must be different.',
    'digits'               => 'The :attribute must be :digits digits.',
    'digits_between'       => 'The :attribute must be between :min and :max digits.',
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => 'The :attribute must be a valid email address.',
    'exists'               => 'The selected :attribute is invalid.',
    'file'                 => 'The :attribute must be a file.',
    'filled'               => 'The :attribute field must have a value.',
    'gt'                   => [
        'numeric' => 'The :attribute must be greater than :value.',
        'file'    => 'The :attribute must be greater than :value kilobytes.',
        'string'  => 'The :attribute must be greater than :value characters.',
        'array'   => 'The :attribute must have more than :value items.',
    ],
    'gte'                  => [
        'numeric' => 'The :attribute must be greater than or equal :value.',
        'file'    => 'The :attribute must be greater than or equal :value kilobytes.',
        'string'  => 'The :attribute must be greater than or equal :value characters.',
        'array'   => 'The :attribute must have :value items or more.',
    ],
    'image'                => 'The :attribute must be an image.',
    'in'                   => 'The selected :attribute is invalid.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => 'The :attribute must be an integer.',
    'ip'                   => 'The :attribute must be a valid IP address.',
    'ipv4'                 => 'The :attribute must be a valid IPv4 address.',
    'ipv6'                 => 'The :attribute must be a valid IPv6 address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'lt'                   => [
        'numeric' => 'The :attribute must be less than :value.',
        'file'    => 'The :attribute must be less than :value kilobytes.',
        'string'  => 'The :attribute must be less than :value characters.',
        'array'   => 'The :attribute must have less than :value items.',
    ],
    'lte'                  => [
        'numeric' => 'The :attribute must be less than or equal :value.',
        'file'    => 'The :attribute must be less than or equal :value kilobytes.',
        'string'  => 'The :attribute must be less than or equal :value characters.',
        'array'   => 'The :attribute must not have more than :value items.',
    ],
    'max'                  => [
        'numeric' => 'The :attribute may not be greater than :max.',
        'file'    => 'The :attribute may not be greater than :max kilobytes.',
        'string'  => 'The :attribute may not be greater than :max characters.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => 'The :attribute must be a file of type: :values.',
    'mimetypes'            => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => 'The :attribute must be at least :min.',
        'file'    => 'The :attribute must be at least :min kilobytes.',
        'string'  => 'The :attribute must be at least :min characters.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => 'The selected :attribute is invalid.',
    'not_regex'            => 'The :attribute format is invalid.',
    'numeric'              => 'The :attribute must be a number.',
    'present'              => 'The :attribute field must be present.',
    'regex'                => 'The :attribute format is invalid.',
    'required'             => 'The :attribute field is required.',
    'required_if'          => 'The :attribute field is required when :other is :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'The :attribute field is required when :values is present.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => 'The :attribute and :other must match.',
    'size'                 => [
        'numeric' => 'The :attribute must be :size.',
        'file'    => 'The :attribute must be :size kilobytes.',
        'string'  => 'The :attribute must be :size characters.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => 'The :attribute has already been taken.',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => 'The :attribute format is invalid.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'borrowedItems' => [
            'required' => 'Select games to borrow.'
        ],
        'borrowedItems.*' => [
            'inventory_item_available' => 'The game :item is not available anymore.'
        ],
        'borrowerEmail' => [
            'required' => 'Enter the borrower\'s registered email address.',
            'email' => 'The email address\' format is incorrect.',
            'exists' => 'This email address is not registered in our database.'
        ],
        'borrowerPassword' => [
            'required' => 'Enter the borrower\'s password.',
            'password_for' => 'The password is incorrect.'
        ],
        'startDate' => [
            'required' => 'Choose the borrowing\'s start date.',
            'after_or_equal' => 'The borrowing\'s start date must be superior or equal to the current date.'
        ],
        'expectedReturnDate' => [
            'required' => 'Choose the borrowing\'s expected return date.',
            'after_or_equal' => 'The borrowing\'s expected return date must be superior or equal to the current date.'
        ],
        'guarantee' => [
            'required' => 'Fill in the guarantee.',
            'numeric' => 'The guarantee must be a positive number.',
            'regex' => 'The guarantee must be a positive number with at most 2 decimals.'
        ],
        'agreementCheck1' => [
            'required' => 'You must agree to these terms to proceed.',
            'accepted' => 'You must agree to these terms to proceed.'
        ],
        'agreementCheck2' => [
            'required' => 'You must agree to these terms to proceed.',
            'accepted' => 'You must agree to these terms to proceed.'
        ],
        'selectedBorrowings' => [
            'required' => 'Select borrowings to end.'
        ],
        'durationMin' => [
            'integer' => 'The minimal duration must be an integer.',
            'min' => 'The minimal duration must be positive.'
        ],
        'durationMax' => [
            'integer' => 'The maximal duration must be an integer.',
            'min' => 'The maximal duration must be positive.',
            'gte' => 'The maximal duration must be greater or equal to the minimal duration.'
        ],
        'playersMin' => [
            'integer' => 'The minimal number of players must be an integer.',
            'min' => 'The minimal number of players must be stricly positive.'
        ],
        'playersMax' => [
            'integer' => 'The maximal number of players must be an integer.',
            'min' => 'The maximal number of players must be stricly positive.',
            'gte' => 'The maximal number of players must be greater or equal to the minimal number of players.'
        ],
        'genres' => [
            'required' => 'Please fill in at least one genre for this item.'
        ],
        'genres.*' => [
            'exists' => 'A selected genre doesn\'t exist in our database.'
        ],
        'nameFr' => [
            'required' => 'Please fill in the item\' french name.'
        ],
        'nameEn' => [
            'required' => 'Please fill in the item\' english name.'
        ],
        '' => [

        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'borrowedItems'         => 'selected items to borrow',
        'borrowedItems.*'       => 'selected item to borrow',
        'borrowerEmail'         => 'borrower email',
        'borrowerPassword'      => 'borrower password',
        'guarantee'             => 'guarantee',
        'startDate'             => 'start date',
        'expectedReturnDate'    => 'expected return date',
        'agreementCheck1'       => 'agreement check n°1',
        'agreementCheck2'       => 'agreement check n°2',
        'selectedBorrowings'    => 'selected borrowings',
        'durationMin'           => 'minimal duration',
        'durationMax'           => 'maximal duration',
        'playersMin'            => 'minimal number of players',
        'playersMax'            => 'maximal number of players',
        'genres'                => 'genres',
        'genres.*'              => 'genre',
        'nameFr'                => 'french name',
        'nameEn'                => 'english name'
    ],

];
