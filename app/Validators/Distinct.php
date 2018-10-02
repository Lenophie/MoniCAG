<?php

namespace App\Validators;

use App\Genre;
use App\InventoryItem;
use App\User;
use Illuminate\Support\Facades\App;

class Distinct
{
    public function replacer($message, $attribute, $rule, $parameters, $validator)
    {
        if (substr($attribute, 0, strlen('genres')) === 'genres') {
            return str_replace(
                ':genre',
                Genre::find(array_get($validator->getData(), $attribute))->{'name_' . App::getLocale()},
                $message
            );
        } else if (substr($attribute, 0, strlen('borrowedItems')) === 'borrowedItems') {
            return str_replace(
                ':item',
                InventoryItem::find(array_get($validator->getData(), $attribute))->{'name_' . App::getLocale()},
                $message
            );
        } else if (substr($attribute, 0, strlen('selectedBorrowings')) === 'selectedBorrowings') {
            $borrower = User::with('borrowings')
                ->whereHas('borrowings', function($q) use($validator, $attribute) {
                    $q->where('id', array_get($validator->getData(), $attribute));})
                ->first();
            return str_replace(
                [':item', ':borrower'],
                [
                    InventoryItem::with('borrowing')
                        ->whereHas('borrowing', function($q) use($validator, $attribute) {
                            $q->where('id', array_get($validator->getData(), $attribute));})
                        ->first()
                        ->{'name_' . App::getLocale()},
                    $borrower->first_name . ' ' . $borrower->last_name
                ],
                $message
            );
        }
        return null;
    }
}