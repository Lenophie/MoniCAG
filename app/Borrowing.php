<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'guarantee' => 'double',
        'startDate' => 'date:d/m/Y',
        'expectedReturnDate' => 'date:d/m/Y',
        'returnDate' => 'date:d/m/Y'
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
     * Get the return lender associated with the borrowing.
     */
    public function returnLender()
    {
        return $this
            ->hasOne('App\User', 'id', 'return_lender_id')
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
            ->select('id', 'name_'.App::getLocale().' AS name');
    }

    public static function current() {
        $borrowings = Borrowing::initialJoin()
            ->where('finished', false)
            ->orderByDate()
            ->get();

        foreach($borrowings as $borrowing) {
            self::removeIds($borrowing);
            self::checkLateness($borrowing);
        }

        return $borrowings;
    }

    public static function history() {
        $borrowings = Borrowing::completeJoin()
            ->orderByDate()
            ->get();

        foreach($borrowings as $borrowing) {
            self::removeIds($borrowing);
        }

        return $borrowings;
    }

    public static function userCurrentHistory($userId) {
        $borrowings = Borrowing::completeJoin()
            ->where([
                'borrower_id' => $userId,
                'finished' => 0])
            ->orderByDate()
            ->get();

        foreach($borrowings as $borrowing) {
            self::removeIds($borrowing);
        }

        return $borrowings;
    }

    private static function initialJoin() {
        return Borrowing::with(['initialLender', 'borrower', 'inventoryItem'])
            ->select('id',
                'inventory_item_id',
                'finished',
                'initial_lender_id',
                'borrower_id',
                'start_date AS startDate',
                'expected_return_date AS expectedReturnDate',
                'guarantee');
    }

    private static function completeJoin() {
        return Borrowing::with(['initialLender', 'returnLender', 'borrower', 'inventoryItem'])
            ->select('id',
                'inventory_item_id',
                'finished',
                'initial_lender_id',
                'return_lender_id',
                'borrower_id',
                'start_date AS startDate',
                'expected_return_date AS expectedReturnDate',
                'return_date AS returnDate',
                'guarantee');
    }

    private static function removeIds($borrowing) {
        unset($borrowing->inventory_item_id);
        unset($borrowing->initial_lender_id);
        unset($borrowing->return_lender_id);
        unset($borrowing->borrower_id);
    }

    private static function checkLateness($borrowing) {
        if (Carbon::now()->startOfDay()->gt($borrowing->expectedReturnDate)) $borrowing->isLate = true;
        else $borrowing->isLate = false;
    }

    public static function scopeOrderByDate($query) {
        return $query->orderBy('expectedReturnDate', 'asc')
            ->orderBy('startDate', 'asc');
    }
}
