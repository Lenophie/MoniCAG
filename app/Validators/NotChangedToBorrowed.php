<?php

namespace App\Validators;

use App\InventoryItemStatus;

class NotChangedToBorrowed
{
    public function validate($attribute, $value, $parameters, $validator)
    {
        $inventoryItem = array_get($validator->getData(), $parameters[0]);
        if ($inventoryItem) {
            $status = $inventoryItem->status_id;
            if ($status === InventoryItemStatus::BORROWED) return true;
            if ((int) $value !== InventoryItemStatus::BORROWED) return true;
        }
        return false;
    }
}
