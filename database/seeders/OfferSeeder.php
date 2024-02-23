<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Location;
use App\Models\Offer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $offers = Offer::factory()->count(10)->create();

        foreach ($offers as $offer) {
            $categories = Category::inRandomOrder()->limit(5)->get();
            $locations = Location::inRandomOrder()->limit(5)->get();
            $offer->categories()->sync($categories->pluck('id'));
            $offer->locations()->sync($locations->pluck('id'));
        }
    }
}
