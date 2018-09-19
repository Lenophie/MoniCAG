<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    /**
     * Indicates whether attributes are snake cased on arrays.
     *
     * @var bool
     */
    public static $snakeAttributes = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'inventory_item_id',
        'borrower_id',
        'initial_lender_id',
        'guarantee',
        'status_id',
        'start_date',
        'expected_return_date',
        'notes_before'
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
        'expected_return_date'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'startDate' => 'date:d/m/Y',
        'expectedReturnDate' => 'date:d/m/Y'
    ];

    /**
     * Get the initial lender associated with the borrowing.
     */
    public function initialLender()
    {
        return $this
            ->hasOne('App\User', 'id', 'initial_lender_id')
            ->select('id', 'first_name AS firstName', 'last_name as lastName', 'promotion');
    }

    /**
     * Get the borrower associated with the borrowing.
     */
    public function borrower()
    {
        return $this
            ->hasOne('App\User', 'id', 'borrower_id')
            ->select('id', 'first_name AS firstName', 'last_name as lastName', 'promotion');
    }

    /**
     * Get the inventory item associated with the borrowing.
     */
    public function inventoryItem()
    {
        return $this
            ->hasOne('App\InventoryItem', 'id', 'inventory_item_id')
            ->select('id', 'name');
    }

    public static function allCurrent() {
        $borrowings = Borrowing::with(['initialLender', 'borrower', 'inventoryItem'])
            ->select('id',
                'inventory_item_id',
                'finished',
                'initial_lender_id',
                'borrower_id',
                'start_date AS startDate',
                'expected_return_date as expectedReturnDate',
                'guarantee')
            ->where('finished', false)
            ->orderBy('expectedReturnDate', 'asc')
            ->orderBy('startDate', 'asc')
            ->get();

        foreach($borrowings as $borrowing) {
            if (Carbon::now()->startOfDay()->gt($borrowing->expectedReturnDate)) $borrowing->isLate = true;
            else $borrowing->isLate = false;

            unset($borrowing->inventory_item_id);
            unset($borrowing->initial_lender_id);
            unset($borrowing->borrower_id);
        }

        return $borrowings;
    }
}
