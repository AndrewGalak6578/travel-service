<?php

namespace Database\Seeders;

use App\Models\Destination;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DestinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'name' => 'Almaty Eco Weekend',
                'region' => 'Kazakhstan',
                'experience_type' => 'eco',
                'description' => 'Local eco-friendly weekend with hikes and community markets.',
                'highlights' => ['Kok-Tobe hike','Local farmers market','Eco museum'],
                'sustainability_notes' => 'Use public transport, bring reusable bottle.',
            ],
            [
                'name' => 'Bali Sustainable Retreat',
                'region' => 'Indonesia',
                'experience_type' => 'local',
                'description' => 'Stay in eco-lodges and explore local crafts and food.',
                'highlights' => ['Eco lodge','Local craft workshop','Low-impact snorkeling'],
                'sustainability_notes' => 'Avoid single-use plastics, support local guides.',
            ],
        ];

        foreach ($items as $it) {
            Destination::updateOrCreate(
                ['slug' => Str::slug($it['name'])],
                array_merge($it, ['slug' => Str::slug($it['name'])])
            );
        }
    }
}
