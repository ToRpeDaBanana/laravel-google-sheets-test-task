<?php

namespace App\Services;

use App\Models\Item;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ItemService
{
    /**
     * Создание нового элемента.
     */
    public function createItem(array $data)
    {
        return Item::create($data);
    }

    /**
     * Обновление существующего элемента.
     */
    public function updateItem(Item $item, array $data)
    {
        return $item->update($data);
    }

    /**
     * Удаление элемента.
     */
    public function deleteItem(Item $item)
    {
        return $item->delete();
    }

    /**
     * Генерация фейковых данных.
     */
    public function generateFakeData()
    {
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
    }

    /**
     * Очистка таблицы.
     */
    public function clearItems()
    {
        Item::truncate();
    }
}
