<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'inventory_item_id',
        'borrower_id',
        'initial_lender_id',
        'return_lender_id',
        'guarantee',
        'finished',
        'start_date',
        'expected_return_date',
        'return_date',
        'notes_before',
        'notes_after'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'start_date',
        'expected_return_date',
        'return_date'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['is_late'];

    /**
     * Get the initial lender associated with the borrowing.
     */
    public function initialLender()
    {
        return $this->hasOne('App\User', 'id', 'initial_lender_id');
    }

    /**
     * Get the return lender associated with the borrowing.
     */
    public function returnLender()
    {
        return $this->hasOne('App\User', 'id', 'return_lender_id');
    }


    /**
     * Get the borrower associated with the borrowing.
     */
    public function borrower()
    {
        return $this->hasOne('App\User', 'id', 'borrower_id');
    }

    /**
     * Get the inventory item associated with the borrowing.
     */
    public function inventoryItem()
    {
        return $this->hasOne('App\InventoryItem', 'id', 'inventory_item_id');
    }

    /**
     * Get the borrowing's lateness status.
     *
     * @return string
     */
    public function getIsLateAttribute() {
        $expectedReturnDate = Carbon::createFromFormat('Y-m-d', $this->attributes["expected_return_date"]);

        if ($this->attributes["return_date"] !== null) {
            $returnDate = Carbon::createFromFormat('Y-m-d', $this->attributes["return_date"]);
            return $returnDate->gt($expectedReturnDate);
        }

        $currentDate = Carbon::now()->startOfDay();
        return $currentDate->gt($expectedReturnDate);
    }

    /**
     * Scope a query to order by dates.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public static function scopeOrderByDate($query) {
        return $query->orderBy('expected_return_date', 'desc')
            ->orderBy('start_date', 'desc');
    }
}
