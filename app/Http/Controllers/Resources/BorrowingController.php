<?php

namespace App\Http\Controllers\Resources;

use App\Borrowing;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateBorrowingRequest;
use App\Http\Requests\EndBorrowingRequest;
use App\InventoryItem;
use App\InventoryItemStatus;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BorrowingController extends Controller
{
    public function __construct() {
       $this->middleware('auth:api');
    }

    /**
     * Display a listing of borrowings.
     *
     * @return Response
     */
    public function index()
    {
        $borrowings = Borrowing::history();
        return response($borrowings, Response::HTTP_CONTINUE);
    }

    /**
     * Store a newly created borrowing in storage.
     *
     * @param CreateBorrowingRequest $request
     * @return Response
     */
    public function store(CreateBorrowingRequest $request)
    {
        DB::transaction(function() {
            foreach (request('borrowedItems') as $borrowedItem) {
                $expectedReturnDate = Carbon::createFromFormat('Y-m-d', request('expectedReturnDate'));
                $borrowerId = User::where('email', request('borrowerEmail'))->select('id')->first()->id;
                Borrowing::create([
                    'inventory_item_id' => $borrowedItem,
                    'borrower_id' => $borrowerId,
                    'initial_lender_id' => Auth::user()->id,
                    'guarantee' => request('guarantee'),
                    'finished' => false,
                    'start_date' => Carbon::now(),
                    'expected_return_date' => $expectedReturnDate,
                    'notes_before' => htmlspecialchars(request('notes'))
                ]);
                InventoryItem::where('id', $borrowedItem)->update(['status_id' => InventoryItemStatus::BORROWED]);
            }
        });
        return response([], Response::HTTP_CREATED);
    }

    /**
     * Return the specified borrowings in storage.
     *
     * @param EndBorrowingRequest $request
     * @return Response
     */
    public function return(EndBorrowingRequest $request)
    {
        $newInventoryItemsStatus = (int) request('newInventoryItemsStatus');
        DB::transaction(function () use ($newInventoryItemsStatus) {
            foreach (request('selectedBorrowings') as $selectedBorrowing) {
                Borrowing::where('id', $selectedBorrowing)
                    ->update([
                        'finished' => true,
                        'return_lender_id' => Auth::user()->id,
                        'return_date' => Carbon::now()
                    ]);
                InventoryItem::with('borrowing')
                    ->whereHas('borrowing', function($q) use($selectedBorrowing) {
                        $q->where('id', $selectedBorrowing);})
                    ->update(['status_id' => $newInventoryItemsStatus]);
            };
        });

        return response([], Response::HTTP_OK);
    }
}
