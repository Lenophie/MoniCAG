<?php

namespace App\Validators;

use App\Borrowing;
use App\InventoryItem;
use App\User;

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
                    $inventoryItem->name,
                    $borrower->first_name . ' ' . $borrower->last_name
                ],
                $message);
        });

        $isNotAlreadyReturned = Borrowing::find($value)->return_date === null;
        return $isNotAlreadyReturned;
    }
}
