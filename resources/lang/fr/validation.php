<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages.
    |
    */

    'accepted'             => 'Le champ :attribute doit être accepté.',
    'active_url'           => "Le champ :attribute n'est pas une URL valide.",
    'after'                => 'Le champ :attribute doit être une date postérieure au :date.',
    'after_or_equal'       => 'Le champ :attribute doit être une date postérieure ou égale au :date.',
    'alpha'                => 'Le champ :attribute doit contenir uniquement des lettres.',
    'alpha_dash'           => 'Le champ :attribute doit contenir uniquement des lettres, des chiffres et des tirets.',
    'alpha_num'            => 'Le champ :attribute doit contenir uniquement des chiffres et des lettres.',
    'array'                => 'Le champ :attribute doit être un tableau.',
    'before'               => 'Le champ :attribute doit être une date antérieure au :date.',
    'before_or_equal'      => 'Le champ :attribute doit être une date antérieure ou égale au :date.',
    'between'              => [
        'numeric' => 'La valeur de :attribute doit être comprise entre :min et :max.',
        'file'    => 'La taille du fichier de :attribute doit être comprise entre :min et :max kilo-octets.',
        'string'  => 'Le texte :attribute doit contenir entre :min et :max caractères.',
        'array'   => 'Le tableau :attribute doit contenir entre :min et :max éléments.',
    ],
    'boolean'              => 'Le champ :attribute doit être vrai ou faux.',
    'confirmed'            => 'Le champ de confirmation :attribute ne correspond pas.',
    'date'                 => "Le champ :attribute n'est pas une date valide.",
    'date_format'          => 'Le champ :attribute ne correspond pas au format :format.',
    'different'            => 'Les champs :attribute et :other doivent être différents.',
    'digits'               => 'Le champ :attribute doit contenir :digits chiffres.',
    'digits_between'       => 'Le champ :attribute doit contenir entre :min et :max chiffres.',
    'dimensions'           => "La taille de l'image :attribute n'est pas conforme.",
    'distinct'             => 'Le champ :attribute a une valeur en double.',
    'email'                => 'Le champ :attribute doit être une adresse courriel valide.',
    'exists'               => 'Le champ :attribute sélectionné est invalide.',
    'file'                 => 'Le champ :attribute doit être un fichier.',
    'filled'               => 'Le champ :attribute doit avoir une valeur.',
    'gt'                   => [
        'numeric' => 'La valeur de :attribute doit être supérieure à :value.',
        'file'    => 'La taille du fichier de :attribute doit être supérieure à :value kilo-octets.',
        'string'  => 'Le texte :attribute doit contenir plus de :value caractères.',
        'array'   => 'Le tableau :attribute doit contenir plus de :value éléments.',
    ],
    'gte'                  => [
        'numeric' => 'La valeur de :attribute doit être supérieure ou égale à :value.',
        'file'    => 'La taille du fichier de :attribute doit être supérieure ou égale à :value kilo-octets.',
        'string'  => 'Le texte :attribute doit contenir au moins :value caractères.',
        'array'   => 'Le tableau :attribute doit contenir au moins :value éléments.',
    ],
    'image'                => 'Le champ :attribute doit être une image.',
    'in'                   => 'Le champ :attribute est invalide.',
    'in_array'             => "Le champ :attribute n'existe pas dans :other.",
    'integer'              => 'Le champ :attribute doit être un entier.',
    'ip'                   => 'Le champ :attribute doit être une adresse IP valide.',
    'ipv4'                 => 'Le champ :attribute doit être une adresse IPv4 valide.',
    'ipv6'                 => 'Le champ :attribute doit être une adresse IPv6 valide.',
    'json'                 => 'Le champ :attribute doit être un document JSON valide.',
    'lt'                   => [
        'numeric' => 'La valeur de :attribute doit être inférieure à :value.',
        'file'    => 'La taille du fichier de :attribute doit être inférieure à :value kilo-octets.',
        'string'  => 'Le texte :attribute doit contenir moins de :value caractères.',
        'array'   => 'Le tableau :attribute doit contenir moins de :value éléments.',
    ],
    'lte'                  => [
        'numeric' => 'La valeur de :attribute doit être inférieure ou égale à :value.',
        'file'    => 'La taille du fichier de :attribute doit être inférieure ou égale à :value kilo-octets.',
        'string'  => 'Le texte :attribute doit contenir au plus :value caractères.',
        'array'   => 'Le tableau :attribute doit contenir au plus :value éléments.',
    ],
    'max'                  => [
        'numeric' => 'La valeur de :attribute ne peut être supérieure à :max.',
        'file'    => 'La taille du fichier de :attribute ne peut pas dépasser :max kilo-octets.',
        'string'  => 'Le texte de :attribute ne peut contenir plus de :max caractères.',
        'array'   => 'Le tableau :attribute ne peut contenir plus de :max éléments.',
    ],
    'mimes'                => 'Le champ :attribute doit être un fichier de type : :values.',
    'mimetypes'            => 'Le champ :attribute doit être un fichier de type : :values.',
    'min'                  => [
        'numeric' => 'La valeur de :attribute doit être supérieure ou égale à :min.',
        'file'    => 'La taille du fichier de :attribute doit être supérieure à :min kilo-octets.',
        'string'  => 'Le texte :attribute doit contenir au moins :min caractères.',
        'array'   => 'Le tableau :attribute doit contenir au moins :min éléments.',
    ],
    'not_in'               => "Le champ :attribute sélectionné n'est pas valide.",
    'not_regex'            => "Le format du champ :attribute n'est pas valide.",
    'numeric'              => 'Le champ :attribute doit contenir un nombre.',
    'present'              => 'Le champ :attribute doit être présent.',
    'regex'                => 'Le format du champ :attribute est invalide.',
    'required'             => 'Le champ :attribute est obligatoire.',
    'required_if'          => 'Le champ :attribute est obligatoire quand la valeur de :other est :value.',
    'required_unless'      => 'Le champ :attribute est obligatoire sauf si :other est :values.',
    'required_with'        => 'Le champ :attribute est obligatoire quand :values est présent.',
    'required_with_all'    => 'Le champ :attribute est obligatoire quand :values est présent.',
    'required_without'     => "Le champ :attribute est obligatoire quand :values n'est pas présent.",
    'required_without_all' => "Le champ :attribute est requis quand aucun de :values n'est présent.",
    'same'                 => 'Les champs :attribute et :other doivent être identiques.',
    'size'                 => [
        'numeric' => 'La valeur de :attribute doit être :size.',
        'file'    => 'La taille du fichier de :attribute doit être de :size kilo-octets.',
        'string'  => 'Le texte de :attribute doit contenir :size caractères.',
        'array'   => 'Le tableau :attribute doit contenir :size éléments.',
    ],
    'string'               => 'Le champ :attribute doit être une chaîne de caractères.',
    'timezone'             => 'Le champ :attribute doit être un fuseau horaire valide.',
    'unique'               => 'La valeur du champ :attribute est déjà utilisée.',
    'uploaded'             => "Le fichier du champ :attribute n'a pu être téléversé.",
    'url'                  => "Le format de l'URL de :attribute n'est pas valide.",

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
            'required' => 'Sélectionnez des jeux à emprunter.'
        ],
        'borrowedItems.*' => [
            'inventory_item_available' => 'Le jeu :item n\'est plus disponible.'
        ],
        'borrowerEmail' => [
            'required' => 'Veuillez saisir l\'adresse mail de l\'utilisateur souhaitant emprunter.',
            'email' => 'Le format de cette adresse mail est incorrect.',
            'exists' => 'Cette adresse mail n\'existe pas dans notre base de données.'
        ],
        'borrowerPassword' => [
            'required' => 'Veuillez saisir le mot de passe de l\'emprunteur.',
            'password_for' => 'Ce mot de passe est incorrect.'
        ],
        'startDate' => [
            'required' => 'Renseignez une date de début d\'emprunt.',
            'after_or_equal' => 'La date d\'emprunt ne peut pas être inférieure à la date du jour.'
        ],
        'expectedReturnDate' => [
            'required' => 'Renseignez une date de retour prévu.',
            'after_or_equal' => 'La date de retour prévu doit être supérieure ou égale à la date d\'emprunt.'
        ],
        'guarantee' => [
            'required' => 'Renseignez la caution.',
            'numeric' => 'La caution doit être un nombre positif.',
            'regex' => 'La caution doit être un nombre positif à deux décimales maximum.'
        ],
        'agreementCheck1' => [
            'required' => 'Cet engagement est obligatoire.',
            'accepted' => 'Cet engagement est obligatoire.'
        ],
        'agreementCheck2' => [
            'required' => 'Cet engagement est obligatoire.',
            'accepted' => 'Cet engagement est obligatoire.'
        ],
        'selectedBorrowings' => [
            'required' => 'Sélectionnez des emprunts à terminer.'
        ],
        'durationMin' => [
            'integer' => 'La durée minimale doit être un entier.',
            'min' => 'La durée minimale doit être positive.'
        ],
        'durationMax' => [
            'integer' => 'La durée maximale doit être un entier.',
            'min' => 'La durée maximale doit être positive.',
            'gte' => 'La durée maximale doit être supérieure ou égale à la durée minimale.'
        ],
        'playersMin' => [
            'integer' => 'Le nombre minimal de joueurs doit être un entier.',
            'min' => 'Le nombre minimal de joueurs doit être strictement positif.'
        ],
        'playersMax' => [
            'integer' => 'Le nombre maximal de joueurs doit être un entier.',
            'min' => 'Le nombre maximal de joueurs doit être strictement positif.',
            'gte' => 'Le nombre maximal de joueurs doit être supérieur ou égal au nombre minimal de joueurs.'
        ],
        'genres' => [
            'required' => 'Veuillez renseigner au moins un genre pour ce jeu.'
        ],
        'genres.*' => [
            'exists' => 'Un genre sélectionné n\'existe pas dans notre base de données.'
        ],
        'nameFr' => [
            'required' => 'Veuillez renseigner le nom français du jeu.'
        ],
        'nameEn' => [
            'required' => 'Veuillez renseigner le nom anglais du jeu.'
        ],
        'inventoryItemId' => [
            'required' => 'Veuillez selectionner un jeu à supprimer.',
            'integer' => 'Veuillez selectionner un jeu valide à supprimer.',
            'exists' => 'Le jeu sélectionné n\'existe pas dans notre base de données',
            'inventory_item_not_borrowed' => 'Un jeu en cours d\'emprunt ne peut pas être supprimé.'
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
        'name'                  => 'nom',
        'username'              => "nom d'utilisateur",
        'email'                 => 'adresse courriel',
        'first_name'            => 'prénom',
        'last_name'             => 'nom',
        'password'              => 'mot de passe',
        'password_confirmation' => 'confirmation du mot de passe',
        'city'                  => 'ville',
        'country'               => 'pays',
        'address'               => 'adresse',
        'phone'                 => 'téléphone',
        'mobile'                => 'portable',
        'age'                   => 'âge',
        'sex'                   => 'sexe',
        'gender'                => 'genre',
        'day'                   => 'jour',
        'month'                 => 'mois',
        'year'                  => 'année',
        'hour'                  => 'heure',
        'minute'                => 'minute',
        'second'                => 'seconde',
        'title'                 => 'titre',
        'content'               => 'contenu',
        'description'           => 'description',
        'excerpt'               => 'extrait',
        'date'                  => 'date',
        'time'                  => 'heure',
        'available'             => 'disponible',
        'size'                  => 'taille',
        'borrowedItems'         => 'jeux choisis',
        'borrowedItems.*'       => 'jeu choisi',
        'borrowerEmail'         => 'email de l\'emprunteur',
        'borrowerPassword'      => 'mot de passe de l\'emprunteur',
        'guarantee'             => 'caution',
        'startDate'             => 'date de d\'emprunt',
        'expectedReturnDate'    => 'date de retour prévu',
        'agreementCheck1'       => 'engagement n°1',
        'agreementCheck2'       => 'engagement n°2',
        'selectedBorrowings'    => 'emprunts sélectionnés',
        'durationMin'           => 'durée minimale',
        'durationMax'           => 'durée maximale',
        'playersMin'            => 'nombre de joueurs minimal',
        'playersMax'            => 'nombre de joueurs maximal',
        'genres'                => 'genres',
        'genres.*'              => 'genre',
        'nameFr'                => 'nom français',
        'nameEn'                => 'nom anglais'
    ],
];
