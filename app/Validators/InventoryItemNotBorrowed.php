<?php

namespace App\Validators;

use App\InventoryItem;
use App\InventoryItemStatus;

class InventoryItemNotBorrowed
{
    public function validate($attribute, $value, $parameters, $validator)
    {
        $status = InventoryItem::find($value)->status_id;
        return $status !== InventoryItemStatus::BORROWED;
    }
}