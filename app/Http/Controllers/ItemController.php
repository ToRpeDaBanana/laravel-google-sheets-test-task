<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use App\Services\GoogleSheetService;

class ItemController extends Controller
{
    public function index() {
        $items = Item::query()->paginate(10);
        return view('items.index', compact('items'));
    }

    public function create() {
        return view('items.create');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'status' => 'required|in:Allowed,Prohibited',
        ]);
        Item::create($request->all());
        return redirect()->route('items.index');
    }

    public function show(Item $item)
    {
        return view('items.show', compact('item'));
    }
    
    public function edit(Item $item) {
        return view('items.edit', compact('item'));
    }

    public function update(Request $request, Item $item) {
        $item->update($request->all());
        return redirect()->route('items.index');
    }

    public function destroy(Item $item) {
        $item->delete();
        return redirect()->route('items.index');
    }

    public function generateData() {
        $faker = Faker::create();
    
        DB::transaction(function () use ($faker) {
            $data = [];
    
            for ($i = 0; $i < 1000; $i++) {
                $data[] = [
                    'name' => $faker->name,
                    'description' => $faker->sentence,
                    'status' => $i % 2 == 0 ? 'Allowed' : 'Prohibited',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
    
            DB::table('items')->insert($data);
        });
    
        return redirect()->route('items.index')->with('success', '1000 записей успешно сгенерированы!');
    }

    public function clear()
    {
        Item::truncate();

        return redirect()->route('items.index')->with('success', 'Table cleared successfully.');
    }
}
