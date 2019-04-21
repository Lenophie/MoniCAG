<?php

namespace App\Validators;

use App\InventoryItemStatus;

class InventoryItemNotBorrowed
{
    public function validate($attribute, $value, $parameters, $validator)
    {
        $status = $value->status_id;
        return $status !== InventoryItemStatus::BORROWED;
    }
}
