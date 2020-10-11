<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::all();
        return view('item.index', compact('items'));
    }

    public function create(Request $request)
    {
        // POST
        if ($request->isMethod('POST')) {
            dd($request->all());
        }

        // GET
        return view('item.create');
    }
}
