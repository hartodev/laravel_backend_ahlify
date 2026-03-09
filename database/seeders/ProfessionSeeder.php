<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Profession;
use Illuminate\Support\Str;

class ProfessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            'Tukang Bangunan',
            'Handyman',
            'Teknisi AC',
            'Montir',
            'Cleaning Service',
            'Tukang Ledeng',
            'Teknisi Listrik',
            'IT Support',
        ];

        foreach ($items as $item) {
            Profession::updateOrCreate(
                ['slug' => Str::slug($item)],
                [
                    'name' => $item,
                    'is_active' => true,
                ]
            );
        }
    }
}
