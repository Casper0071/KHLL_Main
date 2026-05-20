<?php

namespace Database\Seeders;

use App\Models\AgendaItem;
use Illuminate\Database\Seeder;

class AgendaItemSeeder extends Seeder
{
    public function run(): void
    {
        // Maak 20 willekeurige items als basis
        AgendaItem::factory()->count(20)->create();

        // Specifieke test cases
        AgendaItem::factory()->create([
            'title' => 'LOL: Spellenavond',
            'description' => 'Gezellige spellenavond voor alle leden. Neem je favoriete spel mee!',
            'start_date' => now()->addDays(7)->setTime(19, 00),
            'end_date' => now()->addDays(7)->setTime(23, 00),
            'location' => 'Muziekcentrum',
            'status' => 'published',
            'published_at' => now(),
            'color' => '#3b82f6'
        ]);

        AgendaItem::factory()->create([
            'title' => 'KHLL: Voorjaarsconcert 2026',
            'description' => 'Het jaarlijkse voorjaarsconcert met alle orkesten. Kaartverkoop start 1 maart.',
            'start_date' => now()->addMonths(2)->setTime(20, 00),
            'end_date' => now()->addMonths(2)->setTime(22, 30),
            'location' => 'Cultuurcentrum',
            'status' => 'published',
            'published_at' => now()->subDays(5),
            'color' => '#f59e0b'
        ]);

        AgendaItem::factory()->create([
            'title' => 'Activiteit: Workshop Muziektheorie',
            'description' => 'Leer de basis van muziektheorie in deze interactieve workshop.',
            'start_date' => now()->addDays(14)->setTime(14, 00),
            'end_date' => now()->addDays(14)->setTime(17, 00),
            'location' => 'Muziekschool',
            'status' => 'concept',
            'published_at' => null,
            'color' => '#10b981'
        ]);

        // Toekomstige publicatie
        AgendaItem::factory()->create([
            'title' => 'Zomerconcert onder de sterren',
            'description' => 'Een magisch concert in de buitenlucht. Meer info volgt binnenkort!',
            'start_date' => now()->addMonths(3)->setTime(20, 00),
            'end_date' => now()->addMonths(3)->setTime(23, 00),
            'location' => 'Openluchttheater',
            'status' => 'published',
            'published_at' => now()->addDays(7), // Publiceert over 7 dagen
            'color' => '#3b82f6'
        ]);
    }
}
