<?php

namespace App\Validators;

use App\InventoryItemStatus;

class UnchangedDuringBorrowing
{
    public function validate($attribute, $value, $parameters, $validator)
    {
        $inventoryItem = array_get($validator->getData(), $parameters[0]);
        if ($inventoryItem) {
            $status = $inventoryItem->status_id;
            if ($status !== InventoryItemStatus::BORROWED) return true;
            $oldValue = $inventoryItem->{snake_case($attribute)};
            if ((string) $oldValue === (string) $value) return true;
        }
        return false;
    }
}
