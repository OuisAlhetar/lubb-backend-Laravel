<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Section;

class SectionSeeder extends Seeder
{
    public function run()
    {
        Section::create(['name' => 'Movies']);
        Section::create(['name' => 'Podcasts']);
        Section::create(['name' => 'Audiobooks']);
    }
}
