<?php

namespace App\Http\Controllers\Resources;

use App\Http\Controllers\Controller;

class ExplorationController extends Controller
{
    public function index()
    {
        return [
            'borrowings' => route('borrowings.index'),
            'inventoryItems' => route('inventoryItems.index')
        ];
    }
}
