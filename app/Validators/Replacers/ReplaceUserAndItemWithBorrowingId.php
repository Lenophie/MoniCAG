<?php

namespace App\Validators\Replacers;

use App\InventoryItem;
use App\User;

class ReplaceUserAndItemWithBorrowingId
{
    /**
     * @param $message string
     * @param $borrowingId integer
     * @return string
     */
    public static function replace($message, $borrowingId) {
        $borrower = User::with('borrowings')
            ->whereHas('borrowings', function($q) use($borrowingId) {
                $q->where('id', $borrowingId);})
            ->first();
        $inventoryItem = InventoryItem::with('borrowing')
            ->whereHas('borrowing', function($q) use($borrowingId) {
                $q->where('id', $borrowingId);})
            ->first();
        return str_replace(
            [
                ':item',
                ':borrower'
            ], [
                $inventoryItem->name,
                $borrower->first_name . ' ' . $borrower->last_name
            ], $message
        );
    }
}
