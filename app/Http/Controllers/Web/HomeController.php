<?php

namespace App\Http\Controllers\Web;

use App\Borrowing;
use App\Http\Controllers\Controller;
use App\InventoryItem;
use App\User;
use Illuminate\Support\Facades\Gate;

class HomeController extends Controller
{
    public function index()
    {
        $pagesAuthorizations = [
            'new-borrowing' => Gate::allows('create', Borrowing::class),
            'end-borrowing' => Gate::allows('return', Borrowing::class),
            'borrowings-history' => Gate::allows('viewAny', Borrowing::class),
            'view-inventory' => Gate::allows('viewAny', InventoryItem::class),
            'edit-inventory' => Gate::allows('update', InventoryItem::class),
            'edit-users' => Gate::allows('viewAny', User::class)
        ];

        return view('home', compact('pagesAuthorizations'));
    }
}
