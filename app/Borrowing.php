<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
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
}
