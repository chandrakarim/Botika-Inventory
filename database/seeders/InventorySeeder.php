<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Inventory;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         Inventory::create([
            'inventory_code' => 'INV-001',
            'name' => 'Macbook Pro',
            'type' => 'Laptop',
            'serial_number' => 'MBP001',
            'specification' => 'M1 16GB',
            'status' => 'baik',
            'member_id' => 1,
        ]);

        Inventory::create([
            'inventory_code' => 'INV-002',
            'name' => 'Asus ROG',
            'type' => 'Laptop',
            'serial_number' => 'ROG002',
            'specification' => 'Ryzen 7 16GB',
            'status' => 'baik',
            'member_id' => 2,
        ]);
    }
}
