<?php

namespace App\Http\Controllers;
use App\Items;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Items::latest()->paginate(5);
    }
}
