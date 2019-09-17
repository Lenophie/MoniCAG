<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BorrowingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'inventoryItem' => $this->whenLoaded('inventoryItem', function () {
                return [
                    'name' => $this->inventoryItem->name,
                    'url' => action('Resources\InventoryItemController@show', ['id' => $this->inventoryItem->id])
                ];
            }),
            'borrower' => $this->whenLoaded('borrower', function () {
                return $this->when(
                    $this->borrower !== null,
                    function () {
                        return [
                            'name' => "{$this->borrower->first_name} {$this->borrower->last_name}",
                            'promotion' => $this->borrower->promotion, // TODO: Used by EndBorrowing view, should be moved to ViewsResource with id
                            'url' => action('Resources\UserController@show', ['id' => $this->borrower->id])
                        ];
                    },
                    null
                );
            }),
            'initialLender' => $this->whenLoaded('initialLender', function () {
                return $this->when(
                    $this->initialLender !== null,
                    function () {
                        return [
                            'name' => "{$this->initialLender->first_name} {$this->initialLender->last_name}",
                            'promotion' => $this->initialLender->promotion,
                            'url' => action('Resources\UserController@show', ['id' => $this->initialLender->id])
                        ];
                    },
                    null
                );
            }),
            // When the relationship is not loaded, the attribute is missing
            // When it is loaded, it is not null when the return date is not null
            'returnLender' => $this->whenLoaded(
                'returnLender',
                function () {
                    return $this->when(
                        $this->return_date !== null && $this->returnLender !== null,
                        function () {
                            return [
                                'name' => "{$this->returnLender->first_name} {$this->returnLender->last_name}",
                                'url' => action('Resources\UserController@show', ['id' => $this->returnLender->id])
                            ];
                        },
                        null
                    );
                }
            ),
            'startDate' => $this->start_date->format('d/m/Y'),
            'expectedReturnDate' => $this->expected_return_date->format('d/m/Y'),
            'returnDate' => $this->when(
                $this->return_date !== null,
                function () {
                    return $this->return_date->format('d/m/Y');
                },
                null
            ),
            'isLate' => $this->is_late,
            'guarantee' => $this->guarantee,
            'notes' => [
                'before' => $this->notes_before,
                'after' => $this->notes_after
            ]
        ];
    }
}
