<?php

namespace App\Validators;

use App\InventoryItemStatus;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class UnchangedDuringBorrowing
{
    public function validate($attribute, $value, $parameters, $validator)
    {
        $inventoryItem = Arr::get($validator->getData(), $parameters[0]);
        if ($inventoryItem) {
            $status = $inventoryItem->status_id;
            if ($status !== InventoryItemStatus::BORROWED) return true;
            $oldValue = $inventoryItem->{Str::snake($attribute)};
            if ((string) $oldValue === (string) $value) return true;
        }
        return false;
    }
}
