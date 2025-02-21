<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::all();
        return view('items.index', compact('items'));
    }

    public function create()
    {
        return view('items.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'status' => 'required|in:Allowed,Prohibited',
        ]);

        Item::create($request->all());

        return redirect()->route('items.index')->with('success', 'Item created successfully.');
    }

    public function show(Item $item)
    {
        return view('items.show', compact('item'));
    }

    public function edit(Item $item)
    {
        return view('items.edit', compact('item'));
    }

    public function update(Request $request, Item $item)
    {
        $request->validate([
            'name' => 'required',
            'status' => 'required|in:Allowed,Prohibited',
        ]);

        $item->update($request->all());

        return redirect()->route('items.index')->with('success', 'Item updated successfully');
    }

    public function destroy(Item $item)
    {
        $item->delete();

        return redirect()->route('items.index')->with('success', 'Item deleted successfully');
    }

    public function generate()
    {
        for ($i = 0; $i < 1000; $i++) {
            Item::create([
                'name' => 'Item ' . $i,
                'status' => rand(0, 1) ? 'Allowed' : 'Prohibited',
            ]);
        }

        return redirect()->route('items.index')->with('success', '1000 items generated successfully.');
    }

    public function clear()
    {
        Item::truncate();

        return redirect()->route('items.index')->with('success', 'Table cleared successfully.');
    }
}
