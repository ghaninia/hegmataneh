<?php

namespace Database\Seeders;

use App\Models\Term;
use App\Models\Currency;
use App\Models\Language;
use Illuminate\Database\Seeder;

class TermSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Term::factory()->count(10)->create();
        Currency::factory()->count(5)->create();
        Language::factory()->count(5)->create();
    }
}
