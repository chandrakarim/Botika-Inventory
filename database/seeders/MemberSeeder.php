<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Member;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Member::create([
            'name' => 'Daniel Alexander Carter',
            'position_id' => 1,
            'department_id' => 1,
        ]);

        Member::create([
            'name' => 'Emily Grace Johnson',
            'position_id' => 2,
            'department_id' => 2,
        ]);

        Member::create([
            'name' => 'Michael Benjamin Lee',
            'position_id' => 3,
            'department_id' => 3,
        ]);

        Member::create([
            'name' => 'Sophia Elizabeth Turner',
            'position_id' => 4,
            'department_id' => 1,
        ]);

        Member::create([
            'name' => 'Christopher Nathan Adams',
            'position_id' => 3,
            'department_id' => 3,
        ]);
    }
}
