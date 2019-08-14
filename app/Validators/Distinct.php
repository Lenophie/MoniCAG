<?php

namespace App\Validators;

use App\Genre;
use App\InventoryItem;
use App\Validators\Replacers\ReplaceUserAndItemWithBorrowingId;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;

class Distinct
{
    public function replacer($message, $attribute, $rule, $parameters, $validator)
    {
        $validatorData = $validator->getData(); // Request body
        $value = Arr::get($validatorData, $attribute);

        if (substr($attribute, 0, strlen('genres')) === 'genres') {
            return str_replace(
                ':genre',
                Genre::find($value)->{'name_' . App::getLocale()},
                $message
            );
        } else if (substr($attribute, 0, strlen('borrowedItems')) === 'borrowedItems') {
            return str_replace(
                ':item',
                InventoryItem::find($value)->name,
                $message
            );
        } else if (substr($attribute, 0, strlen('altNames')) === 'altNames') {
            return str_replace(
                ':altName',
                ucwords($value),
                $message
            );
        } else if (substr($attribute, 0, strlen('selectedBorrowings')) === 'selectedBorrowings')
            return ReplaceUserAndItemWithBorrowingId::replace($message, $value);

        return null;
    }
}
