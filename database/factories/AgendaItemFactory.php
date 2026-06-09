<?php

namespace Database\Factories;

use App\Models\AgendaItem;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class AgendaItemFactory extends Factory
{
    protected $model = AgendaItem::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        // Willekeurige start datum (tussen 6 maanden geleden en 12 maanden in de toekomst)
        $startDate = $this->faker->dateTimeBetween('-6 months', '+12 months');

        // Eind datum is optioneel (70% kans op einddatum, 30% alleen startdatum)
        $hasEndDate = $this->faker->boolean(70);
        $endDate = $hasEndDate
            ? (clone $startDate)->modify('+' . $this->faker->numberBetween(1, 8) . ' hours')
            : null;

        // Kleur opties met labels
        $categoryKey = [
            'lol', // LOL (Blauw)
            'khll', // KHLL (Geel)
            'activiteiten'  // Activiteiten (Groen)
        ];

        // Status met gewichten (meer gepubliceerd dan concept)
        $statuses = ['concept', 'published', 'cancelled'];
        $statusWeights = [30, 60, 10]; // 30% concept, 60% published, 10% cancelled

        $status = $this->faker->randomElement($statuses, $statusWeights);

        // Publicatiedatum alleen voor gepubliceerde items
        $publishedAt = null;
        if ($status === 'published') {
            // 70% kans op direct gepubliceerd, 30% kans op geplande publicatie
            if ($this->faker->boolean(70)) {
                $publishedAt = $this->faker->dateTimeBetween('-1 month', 'now');
            } else {
                $publishedAt = $this->faker->dateTimeBetween('now', '+2 months');
            }
        }

        return [
            'title' => $this->generateTitle(),
            'description' => $this->faker->boolean(80)
                ? $this->faker->paragraph($this->faker->numberBetween(1, 3))
                : null,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'location' => $this->faker->boolean(70)
                ? $this->faker->randomElement([
                    'Cultuurcentrum',
                    'Muziekschool',
                    'Dorpshuis',
                    'Koninklijke Harmonie Lentekrans',
                    'Kerkgebouw',
                    'Evenementenhal',
                    $this->faker->city() . ' Schouwburg',
                    'Openluchttheater',
                    'Festivalterrein'
                ])
                : null,
            'status' => $status,
            'published_at' => $publishedAt,
            'categoryKey' => $this->faker->randomElement($categoryKey),
            'additional_data' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Generate a realistic title for agenda items.
     */
    private function generateTitle(): string
    {
        $prefixes = [
            'Concert', 'Repetitie', 'Optreden', 'Evenement', 'Workshop',
            'Masterclass', 'Open Dag', 'Uitvoering', 'Presentatie',
            'Thema-avond', 'Gala', 'Festival', 'Wedstrijd'
        ];

        $subjects = [
            'Voorjaarsconcert', 'Kerstdiner', 'Zomerconcert', 'Lentewandeling',
            'Nieuwjaarsreceptie', 'Open Podium', 'Instrumentale Workshop',
            'Thema-uitvoering', 'Ledenvergadering', 'Jeugdconcert',
            'Oud papier inzameling', 'Kerstviering', 'Muziekquiz'
        ];

        $suffixes = [
            'met alle orkesten', 'met medewerking van', 'extra editie',
            'in het kader van', 'ter ere van', 'onder begeleiding van',
            'voor jong en oud'
        ];

        // Bepaal titel type (80% kans op combinatie)
        if ($this->faker->boolean(80)) {
            return $this->faker->randomElement($prefixes) . ': ' .
                $this->faker->randomElement($subjects);
        } else {
            return $this->faker->randomElement($subjects) . ' ' .
                $this->faker->randomElement($suffixes);
        }
    }

    /**
     * Configure the model factory for published items.
     */
    public function published(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'published',
                'published_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            ];
        });
    }

    /**
     * Configure the model factory for concept items.
     */
    public function concept(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'concept',
                'published_at' => null,
            ];
        });
    }

    /**
     * Configure the model factory for cancelled items.
     */
    public function cancelled(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'cancelled',
                'published_at' => null,
            ];
        });
    }

    /**
     * Configure the model factory for LOL category (blauw).
     */
    public function lol(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'categoryKey' => 'lol',
            ];
        });
    }

    /**
     * Configure the model factory for KHLL category (geel).
     */
    public function khll(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'categoryKey' => 'khll',
            ];
        });
    }

    /**
     * Configure the model factory for Activiteiten category (groen).
     */
    public function activiteiten(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'categoryKey' => 'activiteiten',
            ];
        });
    }

    /**
     * Configure the model factory for items published in the future.
     */
    public function scheduled(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'published',
                'published_at' => $this->faker->dateTimeBetween('+1 day', '+2 months'),
            ];
        });
    }

    /**
     * Configure the model factory for upcoming events.
     */
    public function upcoming(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'start_date' => $this->faker->dateTimeBetween('now', '+3 months'),
                'end_date' => $this->faker->optional(0.7)->dateTimeBetween('+1 day', '+4 months'),
            ];
        });
    }

    /**
     * Configure the model factory for past events.
     */
    public function past(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'start_date' => $this->faker->dateTimeBetween('-6 months', '-1 day'),
                'end_date' => $this->faker->optional(0.5)->dateTimeBetween('-5 months', '-1 hour'),
                'status' => 'published',
                'published_at' => $this->faker->dateTimeBetween('-7 months', '-1 day'),
            ];
        });
    }
}
