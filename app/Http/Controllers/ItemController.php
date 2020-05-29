<?php

// namespace App\Http\Controllers;
// use Illuminate\Http\Request;

namespace App\Http\Controllers;
use App\Item;
use App\ItemKit;
use Illuminate\Http\Request;
// use Illuminate\Database\Eloquent\Model;

class ItemController extends Controller
{
    public function create(Request $request)
    {
        // return ['message' => Item::latest()];

        $item = ItemKit::first();
        return $item;

    }
}
