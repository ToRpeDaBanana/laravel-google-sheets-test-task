<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    public function index() {
        $items = Item::paginate(10);
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
    // public function syncWithGoogleSheets()
    // {
    //     $spreadsheetId = '1v7z-sal_g2M3nf0mUvKbj7TwiR2Coe4OG79FXY0kqT4';
    //     $range = 'Sheet1!A1:D';

    //     $items = Item::where('status', 'Allowed')->get();
    //     $data = $items->map(function ($item) {
    //         return [$item->id, $item->name, $item->status, $item->created_at];
    //     })->toArray();


    //     $this->googleSheetsService->updateSheetData($spreadsheetId, $range, $data);

    //     return redirect()->route('items.index')->with('success', 'Data synced with Google Sheets.');
    // }
}
