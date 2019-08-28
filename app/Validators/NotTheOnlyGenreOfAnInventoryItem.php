<?php

namespace App\Validators;

use App\InventoryItem;
use Illuminate\Support\Facades\App;

class NotTheOnlyGenreOfAnInventoryItem
{
    public function validate($attribute, $value, $parameters, $validator)
    {
        $inventoryItemsForWhichTheSelectedGenreIsTheOnlyOneQuery = InventoryItem::with('genres')
            ->whereHas('genres', function ($q) use ($value) {
                $q->where('genre_id', $value->id); // has the selected genre among its genres
            })
            ->has('genres', '=', 1); // has only one genre

        $problematicInventoryItems = $inventoryItemsForWhichTheSelectedGenreIsTheOnlyOneQuery
            ->get()
            ->implode('name', ', ');

        $validator->addReplacer('not_the_only_genre_of_an_inventory_item',
            function ($message, $attribute, $rule, $parameters) use ($problematicInventoryItems, $value) {
                return str_replace([
                    ':genre',
                    ':items'
                ], [
                    $value->{'name_' . App::getLocale()},
                    $problematicInventoryItems
                ], $message);
            }
        );

        return $inventoryItemsForWhichTheSelectedGenreIsTheOnlyOneQuery->count() === 0;
    }
}
