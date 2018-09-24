<?php

namespace App\Validators;

use App\InventoryItem;
use App\InventoryItemStatus;

class InventoryItemAvailable
{
    public function validate($attribute, $value, $parameters, $validator)
    {
        $validator->addReplacer('inventory_item_available', function ($message, $attribute, $rule, $parameters) use ($value) {
            return str_replace(':item', InventoryItem::find($value)->name, $message);
        });
        $inventoryItem = InventoryItem::find($value);
        if ($inventoryItem) {
            $status = $inventoryItem->status_id;
            if ($status === InventoryItemStatus::IN_LCR_D4
                || $status === InventoryItemStatus::IN_F2) return true;
        }
        return false;
    }
}