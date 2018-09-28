<?php

namespace App\Validators;

use App\InventoryItem;
use App\InventoryItemStatus;

class InventoryItemNotBorrowed
{
    public function validate($attribute, $value, $parameters, $validator)
    {
        $inventoryItem = InventoryItem::find($value);
        if ($inventoryItem) {
            $status = $inventoryItem->status_id;
            if ($status !== InventoryItemStatus::BORROWED) return true;
        }
        return false;
    }
}