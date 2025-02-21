<?php
namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Services\ItemService;
use App\Services\GoogleSheetService;

class ItemController extends Controller
{
    protected $itemService;
    protected $googleSheetService;

    public function __construct(ItemService $itemService, GoogleSheetService $googleSheetService)
    {
        $this->itemService = $itemService;
        $this->googleSheetService = $googleSheetService;
    }

    public function index()
    {
        $items = Item::query()->paginate(10);
        return view('items.index', compact('items'));
    }

    public function create()
    {
        return view('items.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'status' => 'required|in:Allowed,Prohibited',
        ]);

        $this->itemService->createItem($validatedData);

        return redirect()->route('items.index');
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
        $validatedData = $request->validate([
            'name' => 'required',
            'status' => 'required|in:Allowed,Prohibited',
            'description' => 'nullable|string',
        ]);

        $this->itemService->updateItem($item, $validatedData);

        return redirect()->route('items.index');
    }

    public function destroy(Item $item)
    {
        $this->itemService->deleteItem($item);

        return redirect()->route('items.index');
    }

    public function generateData()
    {
        $this->itemService->generateFakeData();

        return redirect()->route('items.index')->with('success', '1000 записей успешно сгенерированы!');
    }

    public function clear()
    {
        $this->itemService->clearItems();

        return redirect()->route('items.index')->with('success', 'Table cleared successfully.');
    }

    // Метод для синхронизации данных с Google Sheets
    public function syncGoogleSheets()
    {
        $this->googleSheetService->syncData();

        return redirect()->route('items.index')->with('success', 'Данные синхронизированы с Google Sheets');
    }
}

