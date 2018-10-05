<?php

namespace App\Validators;

use App\Borrowing;
use App\InventoryItem;
use App\User;
use Illuminate\Support\Facades\App;

class BorrowingNotAlreadyReturned
{
    public function validate($attribute, $value, $parameters, $validator)
    {
        $validator->addReplacer('not_already_returned', function ($message, $attribute, $rule, $parameters) use ($value) {
            $borrower = User::with('borrowings')
                ->whereHas('borrowings', function($q) use($value) {
                    $q->where('id', $value);})
                ->first();
            $inventoryItem = InventoryItem::with('borrowing')
                ->whereHas('borrowing', function($q) use($value) {
                    $q->where('id', $value);})
                ->first();
            return str_replace(
                [':item', ':borrower'],
                [
                    $inventoryItem->{'name_' . App::getLocale()},
                    $borrower->first_name . ' ' . $borrower->last_name
                ],
                $message);
        });


        $isFinished = Borrowing::find($value)->finished;
        return $isFinished === 0;
    }
}