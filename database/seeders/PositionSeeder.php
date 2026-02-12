<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Position;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
             $positions = [
            ['name' => 'Senior Software Engineer'],
            ['name' => 'Marketing and Communications Executive'],
            ['name' => 'Financial Operations Officer'],
            ['name' => 'Quality Assurance'],
        ];

        foreach ($positions as $position) {
            Position::create($position);
        }
    }
}
